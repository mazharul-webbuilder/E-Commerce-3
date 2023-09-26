@extends('webend.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- start menu -->
            <div class="mt-4">
                <ol class="flex items-center space-x-1 md:space-x-3 flex-wrap">
                    <li class="flex items-center">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        <a href="{{ route('dashboard') }}" class="flex items-center font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:scale-105">
                            Home
                        </a>
                    </li>
                    <li aria-current="page" class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <div class="flex items-center">
                            <span class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400">Product's Review</span>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- end menu -->
            <div class="border border-[#8e0789] rounded-md mt-5">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Product Review List</h2>

                </div>
                <div class="py-2 px-1 mt-3" style="overflow-x: auto;">
                    <table class="text-sm text-left text-white border-l border-r" id="dataTableAuthor" style=" width: 100%;">
                        <thead class="text-xs text-white uppercase bg-amber-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    S/N
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Provided By
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Product
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Ratting
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Comment
                                </div>
                            </th>
                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Status
                                </div>
                            </th>

                            <th scope="col" class="px-2 whitespace-nowrap py-3">
                                <div class="text-center">
                                    Provided At
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">
                                <div class="text-center">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr class="hide_row{{$review->id}} bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap border-r text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$review->user->name ?? ''}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center hover:underline">
                                    <a href="{{route('product.product_detail',$review->product->slug)}}" target="_blank">{{$review->product->title}}</a>
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$review->ratting}}
                                </td>
                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$review->comment}}
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    <select review_id="{{$review->id}}" data-action="{{route('review.status.update')}}" class="update_review w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none"
                                            name="review_id">
                                        <option value="0" {{$review->status==0? 'selected' : ''}}>Un publish</option>
                                        <option value="1" {{$review->status==1 ? 'selected' : ''}}>publish</option>

                                    </select>
                                </td>

                                <td class="px-2 py-4 text-black border-r text-center">
                                    {{$review->created_at->diffForHumans()}}
                                </td>
                                <td class="whitespace-nowrap space-x-1 text-center px-2  py-4 flex items-center justify-center mt-3">
                                    <a href="javascriptL:;" data-action="{{route('review.delete')}}"  item_id="{{$review->id}}" type="button" class="delete_item text-white bg-red-500 hover:bg-red-600 transition-all ease-in-out font-medium rounded-md text-sm inline-flex items-center px-3 py-2 text-center deleteConfirmAuthor">
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('extra_js')

    <script>
        // change product status

      $(document).ready(function(){
          $('body').on('change','.update_review',function(){

              let status=$(this).val();
              let review_id=$(this).attr('review_id');
              console.log(review_id)
              $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: $(this).attr('data-action'),
                  method: "POST",
                  data:{review_id:review_id,status:status},
                  success:function(data){
                      swal({
                          title: 'Good job!',
                          text: data.message,
                          icon: data.type,
                          timer: 5000,
                          // buttons: true,
                      })
                  },
              })
          })

          $('body').on('click','.delete_item',function(){
              let item_id=$(this).attr('item_id');
              swal({
                  title: "Do you want to delete?",
                  icon: "info",
                  buttons: true,
                  dangerMode: true,
              })
                  .then((willDelete) => {
                      if (willDelete) {
                          $.ajax({
                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                              url:$(this).attr('data-action'),
                              method:'post',
                              data:{item_id:item_id},
                              success:function(data){
                                  swal({
                                      title: 'Good job!',
                                      text: data.message,
                                      icon: data.type,
                                      timer: 5000,
                                      // buttons: true,
                                  })
                                  $('.hide_row'+item_id).hide();
                              }
                          });

                      }
                  });
          })
      })
    </script>

@endsection



