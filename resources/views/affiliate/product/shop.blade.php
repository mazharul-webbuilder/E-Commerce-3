@extends('affiliate.layout.app')
@section('content')

    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('affiliate.dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Products</span>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5 mb-8">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product List</h2>

                </div>

                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTable" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    S/N
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Thumbnail
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Name
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    View
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-black">

                        </tbody>
                    </table>
                </div>
            </div>
            <a href="fdfsdgdf" onclick="copyURI(event)">Copy cover URL</a>

        </div>
    </section>
    @include('seller.product._config_modal_')
@endsection

@section('extra_js')
    <script>

        function copyURI(evt) {
            evt.preventDefault();
            navigator.clipboard.writeText(evt.target.getAttribute('href')).then(() => {
                /* clipboard successfully set */
            }, () => {
                /* clipboard write failed */
            });
        }
        var table = $("#dataTable").DataTable({
            processing: true,
            responsive: false,
            serverSide: true,
            ordering: false,
            pagingType: "full_numbers",
            ajax: '{{ route('affiliate.shop.product.load') }}',
            columns: [
                { data: 'DT_RowIndex',name:'DT_RowIndex' },
                { data: 'thumbnail',name:'thumbnail'},
                { data: 'product_name',name:'product_name'},
                { data: 'view-details',name:'view-details' },
                { data: 'action',name:'action' },
            ],

            language : {
                processing: 'Processing'
            },

        });
    </script>

    <script>
        $(document).ready(function (){
            $('body').on('click','.add_to_store',function (){
                $(this).text('wait...').prop('disabled',true)

                let item_id=$(this).attr('item_id')

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: $(this).attr('data-action'),
                    method: "post",
                    data: {item_id:item_id},
                    success:function (response){
                        swal({
                            title: 'Good job!',
                            text: response.data,
                            icon: response.type,
                            timer: 5000,
                        })
                        $('#dataTable').DataTable().ajax.reload();

                    },
                    error:function (response){
                        console.log(response.responseText)
                        swal({
                            title: 'Opps!!!',
                            text: response.responseText,
                            icon: response.type,
                            timer: 5000,
                        })
                    }
                })
            })

            // copy link
            $('body').on('click','.copy_link',function (e){
                e.preventDefault();
                var copyText = $(this).attr('share_link');
                $(this).text('Copying...')

                document.addEventListener('copy', function(e) {
                    e.clipboardData.setData('text/plain', copyText);
                    e.preventDefault();
                }, true);
                let result=document.execCommand('copy');
                if (result){
                    swal({
                        title: 'Good job!',
                        text: "Successfully copied",
                        icon: 'success',
                        timer: 5000,
                    })
                }else{
                    swal({
                        title: 'Error!',
                        text: response.data,
                        icon: 'error',
                        timer: 5000,
                    })
                }
                $(this).text('Copy Link')

            })
        })
    </script>
    @include('affiliate.product._affiliate_product_script_')
@endsection
