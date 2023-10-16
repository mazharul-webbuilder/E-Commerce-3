<!-- Modal -->
<div id="flashDealModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="modal-overlay fixed inset-0 bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto">
        <!-- Add your modal content here -->
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-3xl font-semibold text-gray-800">Product Flash Deal</p>
                <button id="flashDealModalClose" class="modal-close cursor-pointer z-50 p-2">
                    <svg class="fill-current text-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M6.293 6.293a1 1 0 0 1 1.414 0L10 10.586l2.293-2.293a1 1 0 1 1 1.414 1.414L11.414 12l2.293 2.293a1 1 0 0 1-1.414 1.414L10 13.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 12 6.293 9.707a1 1 0 0 1 0-1.414z"/>
                    </svg>
                </button>
            </div>
            <p class="text-gray-700 mb-4">Flash Deal Current Status <span id="getFlashDealStatus" class="inline-block px-2 py-1 rounded-full text-white bg-gradient-to-r from-blue-500 to-indigo-500 shadow-md">Active</span></p>

            <!-- Flash Deal Form -->
            <form id="flashDealControlForm">
                @csrf
                <input type="hidden" name="product_id" id="FlashDealProductId">
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="flashDealStatus">Flash Deal Status:</label>
                    <select id="flashDealStatus" name="flashDealStatus" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">NO</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="startDate" >Start Date:</label>
                    <input type="date" id="startDate" name="startDate" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400" placeholder="Select Start Date">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400" placeholder="Select End Date">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400" placeholder="Enter Amount">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 text-sm font-semibold mb-2" for="dealType">Deal Type:</label>
                    <select id="dealType" name="dealType" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-400">
                        <option value="">Select</option>
                        <option value="flat">Flat</option>
                        <option value="percent">Percent</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-400">Set Flash Deal</button>
                </div>
            </form>
            <!-- End of Flash Deal Form -->
        </div>
    </div>
</div>

