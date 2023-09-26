 <div
            data-te-modal-init
           class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
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
                            id="exampleModalLabel">
                            Modal title
                        </h5>
                        <button
                            type="button"
                            class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
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
                        <form class="submit_form" data-action="{{ route('rank.duration.update') }}" method="post">
                            @csrf
                            <input type="hidden" class="set_duration_id" name="duration_id" value="">
                            <div class="flex flex-col gap-2 p-1">
                                <span>Title</span>
                                <input type="text" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_duration_title" value="" name="title">
                                <span class="title_error text-red-400"></span>
                            </div>
                            <div class="flex flex-col gap-2 p-1">
                                <span>Duration</span>
                                <input type="text" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none set_duration" value="" name="duration">
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg
                           focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">Update</button>
                        </form>
                    </div>
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    </div>
                </div>
            </div>
        </div>