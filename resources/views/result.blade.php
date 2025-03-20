@extends("layout")
@section("content")
    <div class="fixed left-0 right-0 top-0 z-20 flex h-20 bg-gray-50 p-3 shadow-lg">
        <div class="flex text-2xl font-bold text-[#008387]">
            <img class="h-12" src="{{ url("images/Side Logo.png") }}" alt="logo">
            <span class="inline-block p-3 align-baseline">Hand Over (OPD)</span>

        </div>
        <button class="my-1 cursor-pointer rounded bg-blue-600 p-3 text-white" type="button" onclick="homeBtn()">
            <i class="fa-solid fa-house"></i> HOME
        </button>
        <div class="flex flex-1 flex-row-reverse gap-3">
            <button class="w-24 cursor-pointer rounded border border-[#008387] p-3 text-[#008387]" type="button"
                onclick="query()">
                Search
            </button>
            <div class="flex">
                <div class="w-24 p-3">VN</div>
                <input class="w-full rounded bg-gray-100 px-3 focus:outline focus:outline-[#008387]" id="vn"
                    type="text" value="{{ $data["query"]["vn"] }}">
            </div>
            <div class="flex">
                <div class="w-24 p-3">Date</div>
                <input class="w-full rounded bg-gray-100 px-3 focus:outline focus:outline-[#008387]" id="date"
                    type="date" value="{{ $data["query"]["date"] }}">
            </div>
        </div>
    </div>
    <div class="h-20">&nbsp;</div>
    <div class="absolute left-0 right-0 z-10 m-auto w-full p-3 md:w-2/3">
        @if ($data["result"])
            <div class="my-6 flex w-full rounded-lg border border-[#008387] bg-gray-50 shadow-lg">
                <div class="w-1/3 py-3">
                    <div class="mt-2 flex-1 text-center text-2xl font-bold text-[#008387]">Hand Over (OPD)</div>
                    <img class="m-auto mb-3 aspect-auto max-h-32 pt-3" src="{{ url("images/Side Logo.png") }}"
                        alt="logo">
                </div>
                <div class="w-2/3 py-3">
                    <div class="text-2xl font-bold text-[#008387]">Patient Info</div>
                    <hr class="my-3 border-[#008387]">
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div class="flex">
                            <div class="w-24 flex-none">Visit Date : </div>
                            <div class="flex-1">{{ $data["info"]["visit"]["date"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">VN : </div>
                            <div class="flex-1">{{ $data["info"]["vn"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">HN : </div>
                            <div class="flex-1">{{ $data["info"]["hn"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">Name : </div>
                            <div clas="flex-1">{{ $data["info"]["name"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">DOB : </div>
                            <div class="flex-1">{{ $data["info"]["dob"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">Age : </div>
                            <div class="flex-1">{{ $data["info"]["age"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">Gender : </div>
                            <div class="flex-1">{{ $data["info"]["gender"] }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-24 flex-none">ประวัติแพ้ยา : </div>
                            <div class="flex-1 text-red-600">{{ $data["info"]["allergic"] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-6 w-full rounded-lg border border-[#008387] bg-gray-50 p-3 shadow-lg">
                <div class="bg-[#008387] p-3 text-2xl font-bold text-white">Situation</div>
                <hr class="my-3 border-[#008387]">
                <table class="w-full table-auto">
                    <thead class="text-[#008387]">
                        <th class="w-1/3 border border-gray-400 p-3 text-xl">Chief Complaint</th>
                    </thead>
                    @foreach ($data["situation"] as $item)
                        <tr class="">
                            <td class="border border-gray-300 p-3">{{ $item["text"] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="my-6 w-full rounded-lg border border-[#008387] bg-gray-50 p-3 shadow-lg">
                <div class="bg-[#008387] p-3 text-2xl font-bold text-white">Background</div>
                <hr class="my-3 text-[#008387]">
                <table class="w-full table-auto">
                    <thead class="">
                        <th class="w-12 border border-gray-400 p-3">#</th>
                        <th class="border border-gray-400 p-3">Clinic</th>
                        <th class="border border-gray-400 p-3">Doctor</th>
                        <th class="border border-gray-400 p-3">Procedure</th>
                        <th class="border border-gray-400 p-3">App Message</th>
                    </thead>
                    @foreach ($data["background"] as $i => $item)
                        <tr class="@if ($i % 2 == 0) bg-[#f7f7f7] @endif">
                            <td class="border border-gray-300 p-3 text-center">{{ $item["suffix"] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item["clinic"] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item["doctor"] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item["procedure"] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item["text"] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="my-6 w-full rounded-lg border border-[#008387] bg-gray-50 p-3 shadow-lg">
                <div class="bg-[#008387] p-3 text-2xl font-bold text-white">Assessment & Recommendation</div>
                <hr class="my-3 text-[#008387]">
                <table class="w-full table-auto">
                    <thead>
                        <th class="border border-gray-400 p-3 text-xl text-[#008387]" colspan="12">
                            Patient Journey
                        </th>
                    </thead>
                    <thead>
                        <th class="border border-gray-400 p-3">Time</th>
                        <th class="border border-gray-400 p-3">Clinic</th>
                        <th class="border border-gray-400 p-3">Doctor</th>
                        <th class="border border-gray-400 p-3">Temperature</th>
                        <th class="border border-gray-400 p-3">Pulse</th>
                        <th class="border border-gray-400 p-3">Respiration</th>
                        <th class="border border-gray-400 p-3">BPSys</th>
                        <th class="border border-gray-400 p-3">BPDias</th>
                        <th class="border border-gray-400 p-3">O2Sat</th>
                        <th class="border border-gray-400 p-3">BMI </th>
                        <th class="border border-gray-400 p-3">Pain Score</th>
                        <th class="border border-gray-400 p-3">V/S Memo</th>
                    </thead>
                    <tbody>
                        @foreach ($data["assessment"] as $index => $item)
                            <td>&nbsp;</td>
                            @if ($item["type"] == "prescript")
                                <tr class="bg-gray-100" onclick="toggleID('#pres{{ $index }}')">
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["time"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["clinic"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["doctor"] }}</td>
                                    <td
                                        class="@if ($item["vitalsigns"]["temperature"] < 35.5 || $item["vitalsigns"]["temperature"] > 37.4) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["temperature"] }}
                                    </td>
                                    <td
                                        class="@if ($item["vitalsigns"]["pulse"] < 60 || $item["vitalsigns"]["pulse"] > 90) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["pulse"] }}
                                    </td>
                                    <td
                                        class="@if ($item["vitalsigns"]["respiration"] < 18 || $item["vitalsigns"]["respiration"] > 20) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["respiration"] }}
                                    </td>
                                    <td
                                        class="@if ($item["vitalsigns"]["bpsys"] < 90 || $item["vitalsigns"]["bpsys"] > 140) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["bpsys"] }}
                                    </td>
                                    <td
                                        class="@if ($item["vitalsigns"]["bpdias"] < 60 || $item["vitalsigns"]["bpdias"] > 90) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["bpdias"] }}
                                    </td>
                                    <td
                                        class="@if ($item["vitalsigns"]["o2sat"] < 96 || $item["vitalsigns"]["o2sat"] > 100) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["o2sat"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["bmi"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center">
                                        {{ $item["vitalsigns"]["pain"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2">
                                        {{ $item["vitalsigns"]["memo"] }}
                                    </td>

                                </tr>
                                <tr class="hidden bg-green-100" id="pres{{ $index }}">
                                    <td class="border border-gray-300 p-2" colspan="2"></td>
                                    <td class="border border-gray-300 p-2 font-bold" colspan="1">
                                        Isolation/Precautions
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center" colspan="2">
                                        {{ $item["iso"] }}</td>
                                    <td class="border border-gray-300 p-2 font-bold" colspan="2">
                                        Consciousness
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center" colspan="1">
                                        {{ $item["con"] }}</td>
                                    <td class="border border-gray-300 p-2 font-bold" colspan="2">
                                        Fall Risk
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center" colspan="2">
                                        {{ $item["fall"] }}</td>
                                </tr>
                                <tr class="bg-gray-100">
                                    <td class="border border-gray-300"></td>
                                    <td class="border border-gray-300 p-2 font-bold text-[#008387]" colspan="1">
                                        Recommendation
                                    </td>
                                    <td class="border border-gray-300 p-2" colspan="10">
                                        {{ $item["recommend"] }}
                                    </td>
                                </tr>
                            @elseif($item["type"] == "lab")
                                <tr class="bg-gray-100">
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["time"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["clinic"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["doctor"] }}</td>
                                    <td class="border border-gray-300 p-2 text-end font-bold" colspan="2">
                                        RemarksMemo
                                    </td>
                                    <td class="border border-gray-300 p-2" colspan="6">
                                        {{ $item["memo"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center font-bold text-[#008387]">
                                        {{ $item["status"] }}
                                    </td>
                                </tr>
                            @elseif($item["type"] == "xray")
                                <tr class="bg-gray-100">
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["time"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["clinic"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["doctor"] }}</td>
                                    <td class="border border-gray-300 p-2 text-end font-bold" colspan="2">
                                        RemarksMemo
                                    </td>
                                    <td class="border border-gray-300 p-2" colspan="6">
                                        {{ $item["memo"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center font-bold text-[#008387]">
                                        {{ $item["status"] }}
                                    </td>
                                </tr>
                            @elseif($item["type"] == "vs")
                                <tr class="bg-[#ffe2c2]">
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["time"] }}</td>
                                    <td class="border border-gray-300 p-2" colspan="2">{{ $item["clinic"] }}</td>
                                    <td
                                        class="@if ($item["temperature"] < 35.5 || $item["temperature"] > 37.4) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["temperature"] }}
                                    </td>
                                    <td
                                        class="@if ($item["pulse"] < 60 || $item["pulse"] > 90) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["pulse"] }}
                                    </td>
                                    <td
                                        class="@if ($item["respiration"] < 18 || $item["respiration"] > 20) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["respiration"] }}
                                    </td>
                                    <td
                                        class="@if ($item["bpsys"] < 90 || $item["bpsys"] > 140) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["bpsys"] }}
                                    </td>
                                    <td
                                        class="@if ($item["bpdias"] < 60 || $item["bpdias"] > 90) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["bpdias"] }}
                                    </td>
                                    <td
                                        class="@if ($item["o2sat"] < 96 || $item["o2sat"] > 100) text-red-600 @endif border border-gray-300 p-2 text-center">
                                        {{ $item["o2sat"] }}
                                    </td>
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["bmi"] }}</td>
                                    <td class="border border-gray-300 p-2 text-center">{{ $item["pain"] }}</td>
                                    <td class="border border-gray-300 p-2">{{ $item["memo"] }}</td>
                                </tr>
                            @elseif($item["type"] == "vs_notification")
                                <tr class="bg-red-400">
                                    <td class="border border-gray-300 p-2">{{ $item["time"] }}</td>
                                    <td class="border border-gray-300 p-2 text-center" colspan="11">แจ้งเตือนวัด
                                        Vital Sign
                                        อีกครั้ง (ทุก 4 ชั่วโมง)</td>
                                </tr>
                            @endif
                            <td>&nbsp;</td>
                        @endforeach
                        <tr class="bg-[#aed89b]">
                            @if ($data["closeVisit"] !== [])
                                <td class="border border-gray-300 p-2 text-center">
                                    {{ $data["closeVisit"][0]["time"] }}
                                </td>
                                <td class="border border-gray-300 p-2 text-center font-bold" colspan="11">
                                    Close Visit {{ $data["closeVisit"][0]["destination"] }}
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="my-6 w-full rounded-lg border border-[#008387] bg-gray-50 shadow-lg">
                <div class="p-3">
                    <div class="text-2xl font-bold text-[#008387]">Remark Memo</div>
                    <hr class="my-3 border-[#008387]">
                    <table class="w-full table-auto">
                        @foreach ($data["memo"] as $item)
                            <tr class="">
                                <td class="w-12 border border-gray-300 p-3">{{ $item["no"] }}</td>
                                <td class="border border-gray-300 p-3">{{ $item["memo"] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @else
            <div
                class="my-6 flex h-[60vh] w-full flex-col items-center justify-center rounded-lg border border-[#008387] bg-gray-50 p-6 text-center shadow-lg">
                ไม่พบ VN นี
            </div>
        @endif
    </div>
    <div class="h-12">&nbsp;</div>
@endsection
@section("scripts")
    <script>
        function homeBtn() {
            window.location.href = '{{ env("APP_URL") }}/'
        }

        $('#vn').keyup(function(e) {
            if (e.keyCode === 13) {
                query()
            }
        });

        function query() {
            var date = $('#date').val();
            var vn = $('#vn').val();

            window.location.href = '{{ env("APP_URL") }}/result?debug=false&date=' + date + '&vn=' + vn
        }

        function toggleID(id) {
            $(id).toggle()
        }
    </script>
@endsection
