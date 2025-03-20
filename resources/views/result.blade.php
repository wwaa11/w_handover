@extends('layout')
@section('content')
    <div class="z-20 flex bg-gray-50 p-3 shadow-lg h-20 fixed top-0 left-0 right-0">
        <div class="text-2xl text-[#008387] font-bold flex">
            <img class="h-12" src="{{ url('images/Side Logo.png') }}" alt="logo">
            <span class="inline-block align-baseline p-3">Hand Over (OPD)</span>

        </div>
        <button class=" my-1 p-3 bg-blue-600 rounded text-white cursor-pointer" type="button" onclick="homeBtn()">
            <i class="fa-solid fa-house"></i> HOME
        </button>
        <div class="flex-1 flex flex-row-reverse gap-3">
            <button class="p-3 w-24 rounded border border-[#008387] text-[#008387] cursor-pointer" type="button"
                onclick="query()">
                Search
            </button>
            <div class="flex">
                <div class="p-3 w-24">VN</div>
                <input class="bg-gray-100 w-full px-3 focus:outline focus:outline-[#008387] rounded" id="vn"
                    type="text" value="{{ $data['query']['vn'] }}">
            </div>
            <div class="flex">
                <div class="p-3 w-24">Date</div>
                <input class=" bg-gray-100 w-full px-3 focus:outline focus:outline-[#008387] rounded" id="date"
                    type="date" value="{{ $data['query']['date'] }}">
            </div>
        </div>
    </div>
    <div class="h-20">&nbsp;</div>
    <div class="z-10 m-auto w-full md:w-2/3 p-3 absolute left-0 right-0">
        @if ($data['result'])
            <div class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387] flex">
                <div class="w-1/3 py-3">
                    <div class="text-center flex-1 text-2xl mt-2 font-bold text-[#008387]">Hand Over (OPD)</div>
                    <img class="max-h-32 pt-3 mb-3 aspect-auto m-auto" src="{{ url('images/Side Logo.png') }}"
                        alt="logo">
                </div>
                <div class="w-2/3 p-3">
                    <div class="text-2xl font-bold text-[#008387]">Patient Info</div>
                    <hr class="border-[#008387] my-3">
                    <div class="gap-3 grid grid-cols-1 md:grid-cols-2">
                        <div class="flex">
                            <div class="flex-none w-24">Visit Date : </div>
                            <div class="flex-1">{{ $data['info']['visit']['date'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">VN : </div>
                            <div class="flex-1">{{ $data['info']['vn'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">HN : </div>
                            <div class="flex-1">{{ $data['info']['hn'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">Name : </div>
                            <div clas="flex-1">{{ $data['info']['name'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">DOB : </div>
                            <div class="flex-1">{{ $data['info']['dob'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">Age : </div>
                            <div class="flex-1">{{ $data['info']['age'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">Gender : </div>
                            <div class="flex-1">{{ $data['info']['gender'] }}</div>
                        </div>
                        <div class="flex">
                            <div class="flex-none w-24">ประวัติแพ้ยา : </div>
                            <div class="flex-1 text-red-600">{{ $data['info']['allergic'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387]">
                <div class="p-3">
                    <div class="text-2xl font-bold bg-[#008387] text-white p-3">Situation</div>
                    <hr class="border-[#008387] my-3">
                    <table class="w-full table-auto">
                        <thead class="text-[#008387]">
                            <th class="w-1/3 p-3 border border-gray-400 text-xl">Chief Complaint</th>
                        </thead>
                        @foreach ($data['situation'] as $item)
                            <tr class="">
                                <td class="p-3 border border-gray-300">{{ $item['text'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387]">
                <div class="p-3">
                    <div class="text-2xl font-bold bg-[#008387] text-white p-3">Background</div>
                    <hr class="text-[#008387] my-3">
                    <table class="w-full table-auto">
                        <thead class="">
                            <th class="w-12 p-3 border border-gray-400">#</th>
                            <th class="p-3 border border-gray-400">Clinic</th>
                            <th class="p-3 border border-gray-400">Doctor</th>
                            <th class="p-3 border border-gray-400">Procedure</th>
                            <th class="p-3 border border-gray-400">App Message</th>
                        </thead>
                        @foreach ($data['background'] as $i => $item)
                            <tr class="@if ($i % 2 == 0) bg-[#f7f7f7] @endif">
                                <td class="text-center p-3 border border-gray-300">{{ $item['suffix'] }}</td>
                                <td class="p-3 border border-gray-300">{{ $item['clinic'] }}</td>
                                <td class="p-3 border border-gray-300">{{ $item['doctor'] }}</td>
                                <td class="p-3 border border-gray-300">{{ $item['procedure'] }}</td>
                                <td class="p-3 border border-gray-300">{{ $item['text'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387]">
                <div class="p-3">
                    <div class="text-2xl font-bold text-white bg-[#008387] p-3">Assessment & Recommendation</div>
                    <hr class="text-[#008387] my-3">
                    <table class="w-full table-auto">
                        <thead>
                            <th class="text-[#008387] p-3 text-xl border border-gray-400" colspan="12">
                                Patient Journey
                            </th>
                        </thead>
                        <thead>
                            <th class="p-3 border border-gray-400">Time</th>
                            <th class="p-3 border border-gray-400">Clinic</th>
                            <th class="p-3 border border-gray-400">Doctor</th>
                            <th class="p-3 border border-gray-400">Temperature</th>
                            <th class="p-3 border border-gray-400">Pulse</th>
                            <th class="p-3 border border-gray-400">Respiration</th>
                            <th class="p-3 border border-gray-400">BPSys</th>
                            <th class="p-3 border border-gray-400">BPDias</th>
                            <th class="p-3 border border-gray-400">O2Sat</th>
                            <th class="p-3 border border-gray-400">BMI </th>
                            <th class="p-3 border border-gray-400">Pain Score</th>
                            <th class="p-3 border border-gray-400">V/S Memo</th>
                        </thead>
                        <tbody>
                            @foreach ($data['assessment'] as $index => $item)
                                <td>&nbsp;</td>
                                @if ($item['type'] == 'prescript')
                                    <tr class="bg-gray-100" onclick="toggleID('#pres{{ $index }}')">
                                        <td class="text-center p-2 border border-gray-300">{{ $item['time'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['clinic'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['doctor'] }}</td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['temperature'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['pulse'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['respiration'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['bpsys'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['bpdias'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['o2sat'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['bmi'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center">
                                            {{ $item['vitalsigns']['pain'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300">
                                            {{ $item['vitalsigns']['memo'] }}
                                        </td>

                                    </tr>
                                    <tr class="bg-green-100 hidden" id="pres{{ $index }}">
                                        <td class="p-2 border border-gray-300" colspan="2"></td>
                                        <td class="p-2 border border-gray-300 font-bold" colspan="1">
                                            Isolation/Precautions
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center" colspan="2">
                                            {{ $item['iso'] }}</td>
                                        <td class="p-2 border border-gray-300 font-bold" colspan="2">
                                            Consciousness
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center" colspan="1">
                                            {{ $item['con'] }}</td>
                                        <td class="p-2 border border-gray-300 font-bold" colspan="2">
                                            Fall Risk
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center" colspan="2">
                                            {{ $item['fall'] }}</td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="border border-gray-300"></td>
                                        <td class="p-2 border border-gray-300 font-bold text-[#008387]" colspan="1">
                                            Recommendation
                                        </td>
                                        <td class="p-2 border border-gray-300" colspan="10">
                                            {{ $item['recommend'] }}
                                        </td>
                                    </tr>
                                @elseif($item['type'] == 'lab')
                                    <tr class="bg-gray-100">
                                        <td class="text-center p-2 border border-gray-300">{{ $item['time'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['clinic'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['doctor'] }}</td>
                                        <td class="p-2 border border-gray-300 text-end font-bold" colspan="2">
                                            RemarksMemo
                                        </td>
                                        <td class="p-2 border border-gray-300" colspan="6">
                                            {{ $item['memo'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center text-[#008387] font-bold">
                                            {{ $item['status'] }}
                                        </td>
                                    </tr>
                                @elseif($item['type'] == 'xray')
                                    <tr class="bg-gray-100">
                                        <td class="text-center p-2 border border-gray-300">{{ $item['time'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['clinic'] }}</td>
                                        <td class="p-2 border border-gray-300">{{ $item['doctor'] }}</td>
                                        <td class="p-2 border border-gray-300 text-end font-bold" colspan="2">
                                            RemarksMemo
                                        </td>
                                        <td class="p-2 border border-gray-300" colspan="6">
                                            {{ $item['memo'] }}
                                        </td>
                                        <td class="p-2 border border-gray-300 text-center text-[#008387] font-bold">
                                            {{ $item['status'] }}
                                        </td>
                                    </tr>
                                @elseif($item['type'] == 'vs')
                                    <tr class="bg-[#ffe2c2]">
                                        <td class="text-center p-2 border border-gray-300">{{ $item['time'] }}</td>
                                        <td class="border p-2 border-gray-300" colspan="2">{{ $item['clinic'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['temperature'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['pulse'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['respiration'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['bpsys'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['bpdias'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['o2sat'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['bmi'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center">{{ $item['pain'] }}</td>
                                        <td class="border p-2 border-gray-300">{{ $item['memo'] }}</td>
                                    </tr>
                                @elseif($item['type'] == 'vs_notification')
                                    <tr class="bg-red-400">
                                        <td class="border p-2 border-gray-300">{{ $item['time'] }}</td>
                                        <td class="border p-2 border-gray-300 text-center" colspan="11">แจ้งเตือนวัด
                                            Vital Sign
                                            อีกครั้ง (ทุก 4 ชั่วโมง)</td>
                                    </tr>
                                @endif
                                <td>&nbsp;</td>
                            @endforeach
                            <tr class="bg-[#aed89b]">
                                @if ($data['closeVisit'] !== [])
                                    <td class="p-2 border border-gray-300 text-center">
                                        {{ $data['closeVisit'][0]['time'] }}
                                    </td>
                                    <td class="p-2 border border-gray-300 font-bold text-center" colspan="11">
                                        Close Visit {{ $data['closeVisit'][0]['destination'] }}
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387]">
                <div class="p-3">
                    <div class="text-2xl font-bold text-[#008387]">Remark Memo</div>
                    <hr class="border-[#008387] my-3">
                    <table class="w-full table-auto">
                        @foreach ($data['memo'] as $item)
                            <tr class="">
                                <td class="w-12 p-3 border border-gray-300">{{ $item['no'] }}</td>
                                <td class="p-3 border border-gray-300">{{ $item['memo'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @else
            <div
                class="bg-gray-50 w-full rounded-lg shadow-lg my-6 border border-[#008387] p-6 text-center flex flex-col items-center justify-center h-[60vh]">
                ไม่พบ VN นี
            </div>
        @endif
    </div>
    <div class="h-12">&nbsp;</div>
@endsection
@section('scripts')
    <script>
        function homeBtn() {
            window.location.href = '{{ env('APP_URL') }}/'
        }

        $('#vn').keyup(function(e) {
            if (e.keyCode === 13) {
                query()
            }
        });

        function query() {
            var date = $('#date').val();
            var vn = $('#vn').val();

            window.location.href = '{{ env('APP_URL') }}/result?debug=false&date=' + date + '&vn=' + vn
        }

        function toggleID(id) {
            $(id).toggle()
        }
    </script>
@endsection
