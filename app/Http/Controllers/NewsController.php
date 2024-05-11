<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;
class NewsController extends Controller
{
    //

    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        #$fileName = time() . '.' . $request->image->extension();
        #$request->image->move(public_path('news_images'), $fileName);
        $newsItem = News::findOrFail($request->itemId);
         $fileName = $newsItem->files;
        #$fileName = time() . '.' . $request->pdf->extension();
        #$request->pdf->move(public_path('news_pdfs'), $fileName);
        if ($request->hasFile('image')) {
            // Delete existing PDF file
            if ($newsItem->files) {
                File::delete('news_images/' . $newsItem->files);
            }

            // Upload new PDF file
            $fileName = time() . '.' . $request->image->extension();
            
            $request->image->move(public_path('news_images'), $fileName);
        }
        $item = News::updateOrCreate(
            ['id' => $request->itemId],
            ['title' => $request->title, 
            'content' => $request->content,
            'files' => $fileName,
            ]
        );

        return response()->json($item);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
            #'pdf' => 'required|mimes:pdf|max:2048'
        ]);

         // Find the news item by its ID
        $newsItem = News::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete existing PDF file
            if ($newsItem->files) {
                File::delete('news_images/' . $newsItem->files);
            }

            // Upload new PDF file
            $fileName = time() . '.' . $request->image->extension();
            $newsItem->files->move(public_path('news_images'), $fileName);
            $newsItem->files = $fileName;
        }


        // Update the news item with the validated data
        $newsItem->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'files' => $fileName,
        ]);

        // Return a JSON response indicating success
        return response()->json(['message' => 'News item updated successfully']);
    }

    public function destroy($id)
    {
        // Find the news item by its ID
        $newsItem = News::findOrFail($id);

        // Delete the news item
        $newsItem->delete();

        // Return a JSON response indicating success
        return response()->json(['message' => 'News item deleted successfully']);
    }
}
