<!-- Modal -->
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Item Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="itemForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="itemId" name="itemId">
                    <div class="form-group">
                        <label for="title">title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="content">content</label>
                        <textarea class="form-control" id="content" name="content"> </textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-group" id="fileLink">
                        </div>
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveItem">Save changes</button>
            </div>
        </div>
    </div>
</div>