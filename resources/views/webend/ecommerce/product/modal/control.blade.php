<div
    class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
        >
            <div
                class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md"
            >
                <h5
                    class="text-xl font-medium leading-normal text-gray-800"
                    id="exampleModalLabel"
                >
                    Control Product
                </h5>
                <button
                    type="button"
                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body relative p-4">

                <!-- Checkbox start -->
                <input type="hidden" class="store_product_id" name="store_product_id" value="" data-action="{{ route('control_product') }}">
                <div class="flex flex-col gap-2 px-10">
                    <label class="checkbox-container">Recent Product
                        <input type="checkbox" id="recents" class="control_product_status recent" status_type="recent" checked>
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">Best Sale
                        <input type="checkbox" id="best_sales" class="control_product_status best_sale" status_type="best_sale" checked>
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">Most Sale
                        <input type="checkbox" id="most_sales" class="control_product_status most_sale" status_type="most_sale" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <!-- Checkbox end -->
            </div>
            <div
                class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md"
            >
                <button
                    type="button"
                    class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="exampleModalControl"
    tabindex="-1"
    aria-labelledby="exampleModalControl"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
        <div
            class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5
                    class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="exampleModalControl">
                    Product Flash Deal
                </h5>
                <button
                    type="button"
                    class="close_modal box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-modal-dismiss
                    aria-label="Close">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative flex-auto p-4" data-te-modal-body-ref>
                <!-- Checkbox start -->
                <input type="hidden" class="store_product_id" name="store_product_id" value="" data-action="{{ route('control_product') }}">
                <div class="flex flex-col gap-2 px-10">
                    <label class="checkbox-container">Recent Product
                        <input type="checkbox" id="recent" class="control_product_status" status_type="recent">
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">Best Sale
                        <input type="checkbox" id="best_sale" class="control_product_status" status_type="best_sale">
                        <span class="checkmark"></span>
                    </label>
                    <label class="checkbox-container">Most Sale
                        <input type="checkbox" id="most_sale" class="control_product_status" status_type="most_sale">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <!-- Checkbox end -->
            </div>
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
            </div>
        </div>
    </div>
</div>

