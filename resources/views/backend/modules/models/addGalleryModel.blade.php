<div class="modal fade" id="assigning" tabindex="-1" role="dialog" aria-labelledby="assigning" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-toggle-wrapper  text-start dark-sign-up">
				<div class="modal-header">
                    <h4 class="modal-title">Add gallery</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="{{ route('roomtype.dataimagesEditUpload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="imgEditUploadID">
                        <div class="dropzone" id="myDropzoneEdit">
                            <div class="dz-message needsclick">
                                <i class="icon-cloud-up"></i>
                                <h4 class="f-w-700">Drop files here or click to upload.</h4>
                                <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary submit-button-edit" type="submit">Submit</button>
                        <button class="btn btn-primary roomTypeSubmitEditSpinn d-none" type="button">
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Please Wait...</span>
                        </button>
                    </div>
                </form>
            </div>
         </div>
    </div>
</div>