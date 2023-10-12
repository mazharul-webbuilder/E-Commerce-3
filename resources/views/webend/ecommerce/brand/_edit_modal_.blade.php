<!-- Modal -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
        <!-- Add your modal content here -->
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-3xl font-semibold text-gray-800">Edit Brand</p>
                {{--Modal Close button--}}
                <button id="editModalClose" class="modal-close cursor-pointer z-50 p-2">
                    <svg class="fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M6.293 6.293a1 1 0 0 1 1.414 0L10 10.586l2.293-2.293a1 1 0 1 1 1.414 1.414L11.414 12l2.293 2.293a1 1 0 0 1-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 12 6.293 9.707a1 1 0 0 1 0-1.414z"/>
                    </svg>
                </button>
            </div>
            <!-- Flash Deal Form -->
            <form class="updateForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="brand-id" name="id">
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="amount">Name*</label>
                    <input type="text" id="brandName" name="brand_name" class="brandName w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400" placeholder="Enter Name">
                    <span class="error-message" id="email-error"></span>
                </div>
                <div class="py-2">
                    <p class="text-sm text-black pb-2">Current Logo</p>
                    <img src="" alt="" class="existing-image" height="100" width="80">
                </div>
                <div class="mb-4">
                    <h4 class="mb-2 font-medium text-gray">Image <span>(256*200)</span> </h4>
                    <div class="relative inline-flex w-full">
                        <input  type='file' name="image"  class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none dropify"/>
                        <span class="error-message" id="email-error"></span>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="submit-btn bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-400">Update</button>
                </div>
            </form>
            <!-- End of Flash Deal Form -->
        </div>
    </div>
</div>

