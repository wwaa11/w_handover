@extends('layout')
@section('content')
    <div class="flex flex-col items-center justify-center h-screen">
        <div class="rounded m-auto w-full md:w-1/2 lg:w-[30vw] bg-white shadow-lg border-2 border-gray-200">
            <div class="rounded-t p-3 flex bg-gray-100 mb-3">
                <img class="flex-none h-14" src="{{ url('images/Side Logo.png') }}" alt="logo">
                <div class="pt-4 text-2xl font-bold text-[#008387] text-center flex-1">Hand Over(OPD)</div>
            </div>
            <div class="flex px-3 mb-3">
                <div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">วันที่</div>
                <input id="date"
                    class="flex-1 p-3 rounded-e bg-white border border-gray-200 focus:outline focus:outline-[#008387]"
                    type="date" value={{ date('Y-m-d') }}>
            </div>
            <div class="flex px-3 mb-3">
                <div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">VN</div>
                <input id="vn"
                    class="flex-grow p-3 rounded-e bg-white border text-[#008387] border-gray-200 focus:outline focus:outline-[#008387]"
                    type="text" autocomplete="off">
            </div>
            <div class="flex px-3 mb-3">
                <div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">HN</div>
                <input id="hn"
                    class="flex-1 p-3 rounded-e bg-white border text-[#008387] border-gray-200 focus:outline focus:outline-[#008387]"
                    type="text" autocomplete="off">
                <div onclick="searchHN()" class="text-center w-24 p-3 bg-[#008387] text-white rounded-e cursor-pointer">
                    Search
                </div>
            </div>
            <div class="px-3" id="result">
                <div class="flex mb-3">
                    <div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">Name</div>
                    <input id="name"class="flex-1 bg-gray-100 p-3 rounded-e border border-gray-200" disabled
                        type="text">
                </div>
                <div class="flex mb-3">
                    <div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">DOB</div>
                    <input id="dob"class="flex-1 bg-gray-100 p-3 rounded-e border border-gray-200" disabled
                        type="text">
                </div>
                <div id="resultVN"></div>
            </div>
            <div class="rounded-b p-3 flex bg-gray-100 gap-3">
                <button onclick="search()"
                    class="flex-1 p-3 text-center bg-[#008387] text-white m-auto rounded cursor-pointer"
                    type="button">View</button>
                <button class="bg-red-500 rounded text-white cursor-pointer w-12" onclick="resetFn()">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#vn').keyup(function(e) {
            vn = $('#vn').val()
            if (vn.length == 4) {
                searchVN()
            }
            if (e.keyCode === 13) {
                search()
            }
        });

        async function searchVN() {
            date = $('#date').val()
            vn = $('#vn').val()
            vn_length = vn.length
            if (vn_length == 4) {
                await axios.post('{{ env('APP_URL') }}/searchVN', {
                    'date': date,
                    'vn': vn,
                }).then((res) => {
                    if (res.data.status == 'success') {
                        $('#hn').val(res.data.hn);
                        $('#name').val(res.data.name);
                        $('#dob').val(res.data.dob);
                    } else {
                        $('#vn').val('')
                        Swal.fire({
                            title: res.data.message,
                            icon: 'error',
                            allowOutsideClick: true,
                            showConfirmButton: true,
                            confirmButtonColor: '#008387'
                        })
                    }
                })
            }
        }

        async function searchHN() {
            date = $('#date').val()
            hn = $('#hn').val()

            if (hn == '') {
                Swal.fire({
                    title: 'Please,fill HN.',
                    icon: 'error',
                    allowOutsideClick: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#008387'
                })

                return;
            } else {
                $('#resultVN').html('')
                Swal.fire({
                    title: 'Searching...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                })
                await axios.post('{{ env('APP_URL') }}/searchHN', {
                    'date': date,
                    'hn': hn,
                }).then((res) => {
                    if (res.data.status == 'success') {
                        res.data.vn.forEach(vn => {
                            html = '<div class="flex mb-3">';
                            html +=
                                '<div class="w-24 p-3 rounded-s bg-gray-100 border border-gray-200">VN</div>';
                            html +=
                                '<input class="flex-1 p-3 rounded-e bg-white border text-[#008387] border-gray-200 focus:outline focus:outline-[#008387]" type="text" disabled value="' +
                                vn + '">';
                            html += '<div onclick="slelctVN(\'' + vn +
                                '\')" class="text-center w-24 p-3 bg-[#008387] text-white rounded-e cursor-pointer">View</div>';
                            html += '</div>';

                            $('#resultVN').append(html)
                        });
                        $('#name').val(res.data.name);
                        $('#dob').val(res.data.dob);
                        swal.close()
                    } else {
                        $('#hn').val('')
                        Swal.fire({
                            title: res.data.message,
                            icon: 'error',
                            allowOutsideClick: true,
                            showConfirmButton: true,
                            confirmButtonColor: '#008387'
                        })
                    }
                })
            }
        }

        function slelctVN(vn) {
            date = $('#date').val();
            window.location.href = '{{ env('APP_URL') }}/result?date=' + date + '&vn=' + vn
        }

        function search() {
            vn = $('#vn').val()
            name = $('#name').val()

            if (vn == '') {
                Swal.fire({
                    title: 'Please, fill VN.',
                    icon: 'error',
                    allowOutsideClick: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#008387'
                })

                return;
            }
            if (name == '') {
                Swal.fire({
                    title: 'Incorrect VN.',
                    icon: 'error',
                    allowOutsideClick: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#008387'
                })

                return;
            }
            date = $('#date').val();
            window.location.href = '{{ env('APP_URL') }}/result?date=' + date + '&vn=' + vn
        }

        function resetFn() {
            $('#date').val('{{ date('Y-m-d') }}');
            $('#hn').val('');
            $('#vn').val('');
            $('#name').val('');
            $('#dob').val('');
        }
    </script>
@endsection
