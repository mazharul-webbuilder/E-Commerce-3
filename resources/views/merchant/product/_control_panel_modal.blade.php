<!-- Modal -->
<div id="ControlPanelModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay fixed inset-0 bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
        <!-- Add your modal content here -->
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-semibold text-gray-800">Product Control Panel</p>
                <button id="ControlPanelModalClose" class="modal-close cursor-pointer z-50 p-2">
                    <svg class="fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M6.293 6.293a1 1 0 0 1 1.414 0L10 10.586l2.293-2.293a1 1 0 1 1 1.414 1.414L11.414 12l2.293 2.293a1 1 0 0 1-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 12 6.293 9.707a1 1 0 0 1 0-1.414z"/>
                    </svg>
                </button>
            </div>
            <!-- Checkbox Controls -->
            <div class="mb-4">
                <label class="block text-gray-600 text-sm font-semibold mb-2">Product Controls:</label>
                <input type="hidden" class="set_product_id" value="">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="" name="recentProduct" class="recentProduct form-checkbox text-blue-500">
                        <span class="ml-2 text-gray-600">Recent Product</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="" name="bestSaleProduct" class="bestSaleProduct form-checkbox text-blue-500">
                        <span class="ml-2 text-gray-600">Best Sale Product</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="" name="mostSaleProduct" class="mostSaleProduct form-checkbox text-blue-500">
                        <span class="ml-2 text-gray-600">Most Sale Product</span>
                    </label>
                </div>
            </div>
            <!-- End of Checkbox Controls -->
        </div>
    </div>
</div>
