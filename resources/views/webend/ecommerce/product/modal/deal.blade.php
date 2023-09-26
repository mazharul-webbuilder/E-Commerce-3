
<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="exampleModalDeal"
    tabindex="-1"
    aria-labelledby="exampleModalDeal"
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
                    id="exampleModalDeal">
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
                <form id="submit_form_deal" data-action="{{route('set_product_flash')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" class="deal_product_id" name="deal_product_id" value="" data-action="{{ route('control_product') }}">
                    <div class="flex flex-col p-4 md:flex-row justify-between gap-3">
                        <div class="w-full">
                            <div class="w-full">
                                <h4 class="mb-2 font-medium text-zinc-700">Flash Deal Status  Current Status: <span class="current_deal  bg-blue-700 p-1 text-white rounded"></span></h4>
                                <select class="deal_status w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                        name="deal_status"  required>
                                    <option value="">Select Status</option>
                                    <option value="1">YES</option>
                                    <option value="0">NO</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="deal_detail">
                        <div class="flex flex-col gap-4 p-4 mt-3 deal_detail_style">
                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Start Date</h4>
                                        <input placeholder="Start Date" name="deal_start_date" class="deal_start_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" >
                                        <span class="title_error text-red-400"></span>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">End Date</h4>
                                        <input placeholder="End Date" name="deal_end_date" class="deal_end_date w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="text" >
                                        <span class="weight_error text-red-400"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row justify-between gap-3">
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Amount</h4>
                                        <input placeholder="Amount" min="0.01" name="deal_amount"  class="deal_amount w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number" step="0.01" >
                                        <span class="previous_price_error text-red-400"></span>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Deal Type Current:<span class="current_type bg-blue-700 p-1 text-white rounded"></span></h4>
                                        <select class="deal_type w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                                name="deal_type" >
                                            <option value="">Select Type</option>
                                            <option value="flat">Flat</option>
                                            <option value="percent">Percent</option>
                                        </select>
                                        <span class="current_price_error text-red-400"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full p-4 flex justify-end">
                            <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                Set Flash Deal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
            </div>
        </div>
    </div>
</div>
