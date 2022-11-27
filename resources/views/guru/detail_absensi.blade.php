<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi Siswa | Starbhak Absensi</title>
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('assets/CSS/output.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/CSS/suport.css') }}">

    {{-- jquery --}}
    <script src="{{ asset('assets/JS/jquery.js') }}"></script>

    {{-- tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- custom alert -->
    <script src="{{ asset('assets/JS/cstkei.alert.js') }}"></script>

    <!-- config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-dark': '#1061FF',
                        'blue-table': '#002C9D',
                        'blue': '#349DFD',
                        'tet': '#001458',
                        'unselect': '#BAC5E7',
                        'tet-x': '#5A5A5A',
                        'stroke': '#81B7E9',
                    },
                    boxShadow: {
                        nav: '2px 2px 50px 1px rgba(179, 185, 191, 0.1);',
                        side: ' 0px 5px 10px rgba(0, 0, 0, 0.05);',
                    }
                },
            }
        }
    </script>
    <!-- font material ++ -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,500&display=swap"
        rel="stylesheet">
</head>

<body class="text-tet">
    <!-- navbar top -->
    @include('partials.navbar')

    <!-- Sidebar left -->
    @include('partials.sidebar')

    <!-- content -->
    <div class="absolute text-[#1991FF] left-72 w-3/4 py-5 px-16 pb-20">

        <!-- head -->
        <div
            class="shadow-box font-[Montserrat] flex justify-between mt-32 mb-20 p-8 mx-auto rounded-2xl border-solid border-[0.1px] border-opacity-5 border-[#81B7E980]">
            <!-- left side -->
            <div>
                <div>
                    <h1 class=" text-2xl font-bold text-blue-normal-19">Absensi</h1>
                    <p class="text-[#8C8C8C]">Mohon untuk tidak menutup sesi terlalu cepat.</p>
                </div>
                <div class="flex my-5 ml-10">
                    <div class="mr-5">
                        <p class="font-bold text-[#656363]">Mulai Absen</p>
                        <int class="font-bold text-blue-normal-19 text-xl ">
                            {{-- <img src="{{ $symphony }}" alt="{{ $symphony }}"> --}}
                            @foreach ($data_jadwals as $data_jadwal)
                                {{ \Carbon\Carbon::createFromFormat('G:i:s', $data_jadwal->mulai)->format('g:i A') }}
                            @endforeach
                        </int>
                    </div>
                    <div class="mr-5">
                        <p class="font-bold text-[#656363]">Selesai Sesi</p>
                        <int class="font-bold text-blue-normal-19 text-xl ">
                            @foreach ($data_jadwals as $data_jadwal)
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $data_jadwal->selesai)->format('g:i A') }}
                            @endforeach
                        </int>
                    </div>
                    <div>
                        <p class="font-bold text-[#656363]">Batas Hadir</p>
                        <int class="font-bold text-blue-normal-19 text-xl ">
                            @foreach ($data_jadwals as $data_jadwal)
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $data_jadwal->batas_hadir)->format('g:i A') }}
                            @endforeach
                        </int>
                    </div>
                </div>
                <div class="w-fit ml-10">
                    <button class="bg-[#1061FF] px-4 py-1 rounded-xl text-white font-bold"> Masuk </button>
                    <button
                        class=" px-4 py-0.5 border-2 border-solid border-blue-normal-19 text-blue-dark-10 rounded-xl font-bold">Pulang</button>
                </div>
            </div>
            <!-- right side -->
            <div class="font-bold flex flex-col mt-5 mr-5" id="box_absen_keterangan">
                {{-- box Absen Keterangan --}}
            </div>
        </div>
        <!-- tag -->
        <div class="flex my-5 justify-between">
            <h1 class="text-2xl mt-2 font-bold text-blue-normal-19 font-[Montserrat]">Daftar Absensi | @foreach ($data_jadwals as $data_jadwal)
                    {{ $data_jadwal->kelas->kelas }}
                @endforeach
            </h1>
            <button class="px-4 py-3 bg-blue-normal-19 rounded-xl text-white font-bold">Kirim Ke Telegram</button>
        </div>
        <!-- main -->
        <div class="shadow-box p-8 mx-auto rounded-2xl border-solid border-[0.1px] border-opacity-5 border-[#81B7E980]">

            <!-- table -->
            <div class="h-[50vh] w-full overflow-auto" id="table_absen">
                
            </div>

            <!-- control manual -->
            <div class="border-blue border-solid border-t-2 flex justify-between text-sm">

                <!-- leftbar -->
                <div class="font-[Montserrat] w-1/3 min-w-[268px] mt-10 mx-5">
                    <h1 class="font-semibold text-blue-normal-19 text-base">Set Centang</h1>
                    <p class="text-[#8C8C8C] my-4">Atur keterangan Centang</p>

                    <!-- radio -->
                    <div class="flex ml-5">
                        <div class="mr-3">
                            <div class="flex content-center">
                                <input class="mr-2 option-input radio" type="radio" value="Alpha"
                                    name="ket"id="a">
                                <label for="a" class="label-radio">Alpha</label>
                            </div>
                            <div class="flex content-center">
                                <input class="mr-2 option-input radio" type="radio" value="Hadir" name="ket"
                                    id="h">
                                <label for="h" class="label-radio">Hadir</label>
                            </div>
                        </div>
                        <div class="mr-3">
                            <div class="flex content-center">
                                <input class="mr-2 option-input radio" type="radio" value="Terlambat"
                                    name="ket"id="t">
                                <label for="t" class="label-radio">terlambat</label>
                            </div>
                            <div class="flex content-center">
                                <input class="mr-2 option-input radio" type="radio" value="Sakit" name="ket"
                                    id="s">
                                <label for="s" class="label-radio">sakit</label>
                            </div>
                        </div>
                        <input class="mr-2 option-input radio" type="radio" value="Izin" name="ket"
                            id="i">
                        <label for="i" class="label-radio">Izin</label>
                    </div>

                    <!-- confirm -->
                    <p class="py-4">Pastikan untuk tidak salah pilih!</p>
                    <button class="bg-[#1061FF] px-4 py-2 rounded-xl text-white font-bold" onclick="save()">Simpan
                        Perubahan</button>

                </div>

                <!-- rightbar -->
                <div class="w-[33%] max-w-[300px] m-x-5 mt-14">
                    <div class="flex justify-between">
                        <button
                            class="px-4 py-1 border-2 border-solid border-blue-normal-19 text-blue-dark-10 rounded-lg font-bold" onclick="tutup_absen()">Tutup
                            Absen</button>
                        <button class="bg-[#1061FF] px-4 py-2 rounded-lg text-white font-bold" onclick="pulang()" id="pulangkan">Pulangkan</button>
                    </div>
                    <li class="text-[#808080] text-sm my-1">*Tutup absen akan membuat seluruh siswa yang belum
                        memiliki keterangan sebagai belum hadir</li>
                    <li class="text-[#808080] text-sm">*Pulangkan adalah tombol untuk memulangkan siswa yang di
                        pilih. </li>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            box_absen_ket()
            table_absen()
        })

        // menampilkan live status siswa
        function box_absen_ket() {
            $.get("/absen_siswa/{{ $tanggals }}/{{ $kelas }}/{{ $mapels }}/box_ket", {}, function(data,
                status) {
                $("#box_absen_keterangan").html(data)
            })
        }

        // menampilkan live table
        function table_absen() {
            $.get("/absen_siswa/{{ $tanggals }}/{{ $kelas }}/{{ $mapels }}/table_absen", {}, function(
                data, status) {
                $("#table_absen").html(data)
            })
        }

        function centang(any) {
            if (any.checked) {
                var checkbox = document.getElementsByName('checkbox')
                for (r = 0; r < checkbox.length; r++) {
                    checkbox[r].setAttribute('checked', true)
                }
            } else {
                var checkbox = document.getElementsByName('checkbox')
                for (i = 0; i < checkbox.length; i++) {
                    checkbox[i].removeAttribute('checked')
                }
            }
        }

        function tes(any) {
            
            document.getElementById(any).classList.toggle("active")
        }

          
    </script>

</body>

</html>
