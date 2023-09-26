@extends('webend.layouts.master')

@section('content')
    <section class="w-full bg-white p-3 mt-5">
        <div class="container px-2 mx-auto xl:px-5">
            <!-- back button start -->
            <section>
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex-none inline-block">
                        <a href="{{ route('all.tournament') }}" class="flex items-center cursor-pointer justify-center w-9 h-9 bg-white border border-gray-300 rounded-full hover:text-white hover:bg-blue-800 hover:scale-105">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <div class="inline-block">
                        <p class="text-xl">Back</p>
                    </div>
                </div>
            </section>
            <!-- back button end -->

            <!-- table start -->
            <div class="border border-[#8e0789] rounded-md mt-10">
                <div class="bg-[#8e0789] overflow-hidden w-full px-0 flex items-center">
                    <h2 class="text-2xl font-bold py-2 text-white pl-3">Round List</h2>
                    <div class="text-center text-2xl font-bold text-white flex items-center justify-center w-10/12">
                        {{ $tournament->tournament_name }} Details
                    </div>
                </div>
              <form enctype="multipart/form-data" action="{{ route('store.round_ofgame') }}" method="post">
                  @csrf
                  <div class="py-10 px-4 sm:px-14 xl:px-40 mt-3 flex flex-col gap-y-4">
                      <input name="tournament_id" value="{{$tournament->id}}" type="hidden" >

                      @foreach($rounds_setting as $round)
                          @if($round->round_type != 'final')
                              <div class="flex flex-col sm:flex-row gap-y-5 gap-x-10 items-center justify-start w-full mb-2 ">
                                  <div class="text-white py-7 w-40 flex items-center justify-center bg-amber-600 flex-none transition-all ease-in-out font-medium rounded-md text-xl">
                                      Round {{ $round->round_type }}
                                  </div>
                                  @if($tournament->player_type != '2p')
                                      <div class="flex items-start gap-x-5 w-full">
                                          <div class="w-full">
                                              <div class="w-full">
                                                  <h4 class="mb-2 font-medium text-zinc-700 text-center">Time Gaping</h4>
                                                  <div class="flex justify-between items-center gap-x-2">
                                                      @php

                                                      @endphp
                                                      <div class="w-full">
                                                          <select required name="hour{{ $loop->iteration }}" class="js-example-basic-single1 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                              <option value="">Hour</option>
                                                              @for($i = 0;$i<100 ; $i++)
                                                                  <option {{ intdiv($round->time_gaping, 60) == $i ? "selected":'' }} value="{{ $i }}">{{ $i }}</option>
                                                              @endfor
                                                          </select>
                                                      </div>
                                                      <div class="w-full">
                                                          <select required name="min{{ $loop->iteration }}" class="js-example-basic-single2 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                              <option value="">Minute</option>
                                                              @for($i = 1;$i<60 ; $i++)
                                                                  <option {{  ($round->time_gaping % 60) == $i ? "selected":'' }} value="{{ $i }}">{{ $i }}</option>
                                                              @endfor
                                                          </select>
                                                      </div>

                                                  </div>
                                              </div>
                                          </div>
                                          <div class="w-full">
                                              <div class="w-full">
                                                  <h4 class="mb-2 font-medium text-zinc-700">3rd Prize</h4>
                                                  <input required placeholder="Enter 3rd Prize" value="{{ $round->third_bonus_point != null ? $round->third_bonus_point :'' }}" name="third{{$loop->iteration}}" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                              </div>
                                          </div>
                                          <div class="w-full">
                                              <div class="w-full">
                                                  <h4 class="mb-2 font-medium text-zinc-700">4th Prize</h4>
                                                  <input required placeholder="Enter 4th Prize" value="{{ $round->fourth_bonus_point != null ? $round->fourth_bonus_point :'' }}" name="fourth{{$loop->iteration}}" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                              </div>
                                          </div>

                                      </div>
                                  @else
                                      <div class="flex items-start gap-x-5 w-full">
                                          <div class="w-full">
                                              <div class="w-full">
                                                  <h4 class="mb-2 font-medium text-zinc-700 text-center">Time Gaping</h4>
                                                  <div class="flex justify-between items-center gap-x-2">
                                                      <div class="w-full">
                                                          <select required name="hour{{ $loop->iteration }}" class="js-example-basic-single1 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                              <option value="">Hour</option>
                                                              @for($i = 0;$i<100 ; $i++)
                                                                  <option {{ intdiv($round->time_gaping, 60) == $i ? "selected":'' }} value="{{ $i }}">{{ $i }}</option>
                                                              @endfor
                                                          </select>
                                                      </div>
                                                      <div class="w-full">
                                                          <select required name="min{{ $loop->iteration }}" class="js-example-basic-single2 flex items-center w-full pl-4 pr-10 h-12 focus:ring-0 bg-white border border-gray-200 rounded-md appearance-none text-zinc-700 focus:outline-none">
                                                              <option value="">Minute</option>
                                                              @for($i = 1;$i<60 ; $i++)
                                                                  <option {{  ($round->time_gaping % 60) == $i ? "selected":'' }} value="{{ $i }}">{{ $i }}</option>
                                                              @endfor
                                                          </select>
                                                      </div>

                                                  </div>
                                              </div>
                                          </div>

                                          <div class="w-full">
                                              <div class="w-full">
                                                  <h4 class="mb-2 font-medium text-zinc-700"> Prize</h4>
                                                  <input required placeholder="Enter 4th Prize" value="{{ $round->fourth_bonus_point != null ? $round->fourth_bonus_point :'' }}" name="forth{{$loop->iteration}}" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                              </div>
                                          </div>

                                      </div>
                                  @endif
                              </div>
                              <hr>
                          @else

                              <div class="flex flex-col sm:flex-row gap-y-5 gap-x-5 items-center justify-start w-full mt-2 mb-2">
                                  <div class="text-white py-7 w-40 flex items-center justify-center bg-amber-600 flex-none transition-all ease-in-out font-medium rounded-md text-xl">
                                      Final Round
                                  </div>
                                  <div class="flex items-start gap-x-2 xl:gap-x-4 w-full">
                                      <div class="w-full">
                                          <div class="w-full">
                                              <h4 class="mb-2 font-medium text-zinc-700">1st Prize</h4>
                                              <input required placeholder="Enter 1st Prize"  value="{{ $round->first_bonus_point != null ? $round->first_bonus_point : '' }}"  name="first_final" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                          </div>
                                      </div>
                                      <div class="w-full">
                                          <div class="w-full">
                                              <h4 class="mb-2 font-medium text-zinc-700">2nd Prize</h4>
                                              <input required placeholder="Enter 2nd Prize"  value="{{ $round->second_bonus_point != null ? $round->second_bonus_point : '' }}" name="second_final" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                          </div>
                                      </div>
                                      <div class="w-full">
                                          <div class="w-full">
                                              <h4 class="mb-2 font-medium text-zinc-700">3rd Prize</h4>
                                              <input required placeholder="Enter 3rd Prize" value="{{ $round->third_bonus_point != null ? $round->third_bonus_point : ''  }}" name="third_final" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                          </div>
                                      </div>
                                      <div class="w-full">
                                          <div class="w-full">
                                              <h4 class="mb-2 font-medium text-zinc-700">4th Prize</h4>
                                              <input required placeholder="Enter 4th Prize" value="{{ $round->fourth_bonus_point != null ? $round->fourth_bonus_point : '' }}" name="forth_final" class="w-full h-12 px-4 border border-gray-300 rounded-md text-zinc-700 focus:outline-none" type="number">
                                          </div>
                                      </div>

                                  </div>
                              </div>
                          @endif
                      @endforeach
                  </div>
                  <div class="w-full flex justify-end mb-3 pr-40">
                      <button type="submit" class="inline-block px-8 py-2.5 font-medium text-center transition-all ease-in-out text-white rounded-md bg-[#3f3ff3] cursor-pointer hover:bg-blue-800">
                          Update
                      </button>
                  </div>
              </form>
            </div>
            <!-- table end -->
        </div>
    </section>

@endsection
