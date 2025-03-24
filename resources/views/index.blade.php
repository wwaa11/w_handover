@extends("layout")
@section("content")
    <div class="flex h-screen flex-col items-center justify-center">
        <div class="m-auto w-full rounded border-2 border-gray-200 bg-white shadow-lg md:w-1/2 lg:w-[30vw]">
            <div class="mb-3 flex rounded-t bg-gray-100 p-3">
                <img class="h-14 flex-none" src="{{ url("images/Side Logo.png") }}" alt="logo">
                <div class="flex-1 pt-4 text-center text-2xl font-bold text-[#008387]">Hand Over(OPD)</div>
            </div>
            <div class="mb-3 flex px-3">
                <div class="w-24 rounded-s border border-gray-200 bg-gray-100 p-3">วันที่</div>
                <input class="flex-1 rounded-e border border-gray-200 bg-white p-3 focus:outline focus:outline-[#008387]"
                    id="date" type="date" value={{ date("Y-m-d") }}>
            </div>
            <div class="mb-3 flex px-3">
                <div class="w-24 rounded-s border border-gray-200 bg-gray-100 p-3">VN</div>
                <input
                    class="flex-grow rounded-e border border-gray-200 bg-white p-3 text-[#008387] focus:outline focus:outline-[#008387]"
                    id="vn" type="text" autocomplete="off">
            </div>
            <div class="mb-3 flex px-3">
                <div class="w-24 rounded-s border border-gray-200 bg-gray-100 p-3">HN</div>
                <input
                    class="flex-1 rounded-e border border-gray-200 bg-white p-3 text-[#008387] focus:outline focus:outline-[#008387]"
                    id="hn" type="text" autocomplete="off">
                <div class="w-24 cursor-pointer rounded-e bg-[#008387] p-3 text-center text-white" onclick="searchHN()">
                    Search
                </div>
            </div>
            <div class="px-3" id="result">
                <div class="mb-3 flex">
                    <div class="w-24 rounded-s border border-gray-200 bg-gray-100 p-3">Name</div>
                    <input id="name"class="flex-1 bg-gray-100 p-3 rounded-e border border-gray-200" type="text"
                        disabled>
                </div>
                <div class="mb-3 flex">
                    <div class="w-24 rounded-s border border-gray-200 bg-gray-100 p-3">DOB</div>
                    <input id="dob"class="flex-1 bg-gray-100 p-3 rounded-e border border-gray-200" type="text"
                        disabled>
                </div>
                <div id="resultVN"></div>
            </div>
            <div class="flex flex-row gap-3 rounded-b bg-gray-100 p-3">
                <button class="m-auto flex-1 cursor-pointer rounded bg-[#008387] p-3 text-center text-white"
                    id="viewMainBtn" type="button" onclick="search()">View</button>
                <button class="w-12 flex-1 cursor-pointer rounded bg-red-500 p-3 text-white" onclick="resetFn()">
                    <i class="fa-solid fa-arrow-rotate-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
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
                await axios.post('{{ env("APP_URL") }}/searchVN', {
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
            $('#viewMainBtn').hide()
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
                await axios.post('{{ env("APP_URL") }}/searchHN', {
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
            window.location.href = '{{ env("APP_URL") }}/result?debug=false&date=' + date + '&vn=' + vn
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
            window.location.href = '{{ env("APP_URL") }}/result?debug=false&date=' + date + '&vn=' + vn
        }

        function resetFn() {
            $('#viewMainBtn').show()
            $('#date').val('{{ date("Y-m-d") }}');
            $('#hn').val('');
            $('#vn').val('');
            $('#name').val('');
            $('#dob').val('');
            $('#resultVN').html('');
        }
    </script>
@endsection
