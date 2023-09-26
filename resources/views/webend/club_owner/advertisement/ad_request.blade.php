@extends('webend.club_owner.layouts.master')
@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12 mt-4">
                <div class="border border-[#8e0789] rounded-lg col-span-full overflow-hidden">
                    <div class="bg-[#8e0789] text-white overflow-hidden w-full px-0">
                        <h2 class="text-2xl font-bold py-2 pl-3">Advertisement Request</h2>
                    </div>

                    <!-- Tournament form start -->
                    <form id="form_submit" data-action="{{ route('club_owner.submit_ad_request') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4 p-4 mt-3">

                            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                                <div class="w-full regular_registration">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Total Ad</h4>
                                        <input required placeholder="Total Add" min="{{get_advertisement_setting()->minimum_ad_limit}}"
                                               max="{{get_advertisement_setting()->maximum_ad_limit}}" name="total_ad" class="total_ad w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full regular_wining">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Total Day</h4>
                                        <input required placeholder="Total Day" name="total_day" class="total_day w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>

                            </div>
                            <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                                <div class="w-full regular_registration">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Ad Show Per Day</h4>
                                        <input required placeholder="Ad show per day" max="{{get_advertisement_setting()->max_per_day_ad_show}}"  name="ad_show_per_day" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                    </div>
                                </div>
                                <div class="w-full regular_wining">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Ad Duration</h4>
                                        <select name="ad_duration_id" required="" class="select_ad_duration w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            <option value="">Select Ad Duration</option>
                                            @foreach($ad_durations as $data)
                                               <option class="has_slot{{$data->id}}" value="{{$data->id}}" has_slot="{{$data->has_slot}}">{{$data->title}} => Per ad rate {{$data->per_ad_price}}</option>
                                            @endforeach

                                        </select>
                                        <p class="set_calculate_price hidden font-weight-bold"></p>
                                        <input type="hidden" name="total_cost" class="set_total_cost" value="">
                                    </div>
                                </div>

                            </div>

                            <div class="time_slot flex flex-col md:flex-row justify-between items-center gap-3 hidden">
                                <div class="w-full regular_registration">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Time Section</h4>
                                        <select name="time_slot_section_id" class="select_time_slot_section w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                            <option value="">Select Time Slot Section</option>
                                            @foreach($time_slot_sections as $time_slot_section)
                                                <option value="{{$time_slot_section->id}}">{{$time_slot_section->section_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="w-full regular_wining">
                                    <div class="w-full">
                                        <h4 class="mb-2 font-medium text-zinc-700">Time Slot</h4>
                                        <select name="time_slot_id" class="select_time_slot w-full h-12 pl-4 pr-10 cursor-pointer bg-white border border-gray-300 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                <option value="">Select Time Slot</option>
                                                <option value=""></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="w-full flex justify-end">
                                <button type="submit" class="submit_button inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Tournament form end -->
                </div>
            </div>

            <!-- table start -->

            <!-- table end -->
        </div>
    </section>
@endsection
@section('extra_js')
    <script !src="">
        $(document).ready(function (){

            $('body').on('submit','#form_submit',function(e){

                e.preventDefault();
                let formDta = new FormData(this);
                $(".submit_button").html("Processing...").prop('disabled', true)

                $.ajax({
                    url: $(this).attr('data-action'),
                    method: $(this).attr('method'),
                    data: formDta,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data){

                            swal({
                                title: 'Good job!',
                                text: data.message,
                                icon: data.type,
                                timer: 5000,
                            })

                        $(".submit_button").text("Submit").prop('disabled', false)
                    },
                    error:function(response){

                        $(".submit_button").text("Submit").prop('disabled', false)
                    }
                });
            });

            $('body').on('change','.select_ad_duration',function (){
                let ad_duration_id=$(this).val()
                let has_slot=$('.has_slot'+ad_duration_id).attr('has_slot')
                let total_ad=$('.total_ad').val()
                let total_day=$('.total_day').val()

                if(has_slot==1){
                    $('.time_slot').removeClass('hidden')

                    $('.select_time_slot, .select_time_slot_section').attr('required',true)

                }else{
                    $('.time_slot').addClass('hidden')
                    $('.select_time_slot, .select_time_slot_section').attr('required',false)
                }
                if (ad_duration_id!=""){
                    ajax_calculation(ad_duration_id,total_ad,total_day)
                }else{
                    $('.set_calculate_price').addClass('hidden')
                }

            })

            $('body').on('change','.select_time_slot_section',function (){
                let time_slot_selection_id=$(this).val()


                if (time_slot_selection_id!=""){

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:'{{route('club_owner.get_time_slot')}}',
                        method:'post',
                        data:{time_slot_selection_id:time_slot_selection_id},
                        success:function (response){

                                $('.select_time_slot').html(response.data)

                        }
                    })

                }else{
                    $('.select_time_slot').html(' <option value="">Select Time Slot</option>')
                }

            })

            $('body').on('keyup','.total_ad',function (){
                let ad_duration_id=$('.select_ad_duration').val()
                let total_ad=$(this).val()
                let total_day=$('.total_day').val()

                ajax_calculation(ad_duration_id,total_ad,total_day)

            })
            $('body').on('keyup','.total_day',function (){
                let ad_duration_id=$('.select_ad_duration').val()
                let total_ad=$('.total_ad').val()
                let total_day=$(this).val()

                ajax_calculation(ad_duration_id,total_ad,total_day)

            })




            function ajax_calculation(ad_duration_id,total_ad,total_day){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:'{{route('club_owner.advertisement_calculation')}}',
                    method:'post',
                    data:{ad_duration_id:ad_duration_id,total_ad:total_ad,total_day:total_day},
                    success:function (response){
                        if(response.status==200){
                            $('.set_calculate_price').html("<strong>Total Cost: "+response.total_cost+"</strong>").removeClass('hidden')
                            $('.set_total_cost').val(response.total_cost)
                        }else{
                            $('.set_calculate_price').html(response.message).removeClass('hidden')
                        }
                    }
                })
            }

        })
    </script>
@endsection

