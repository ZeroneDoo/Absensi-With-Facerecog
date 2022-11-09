<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa | Starbhak Absensi</title>
    <!-- style css -->
    <link rel="stylesheet" href="../static/assets/CSS/output.css">
    <link rel="stylesheet" href="../static/assets/CSS/suport.css">
    <!-- link cdn -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <!-- config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-dark': '#1061FF',
                        'blue': '#349DFD',
                        'blue-table': '#002C9D',
                        'tet': '#001458',
                        'unselect': '#BAC5E7',
                        'tet-x': '#5A5A5A',
                        'stroke': '#81B7E9',
                    },
                    boxShadow: {
                        nav: '2px 2px 50px 1px rgba(179, 185, 191, 0.1);',
                        side: ' 0px 5px 10px rgba(0, 0, 0, 0.05);',
                        stable: ' 0px 3px 4px rgba(0, 0, 0, 0.25);',
                    }
                },
            }
        }
    </script>
    <!-- font material ++ -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/> <link rel="preconnect" href="https://fonts.googleapis.com"> <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,500&display=swap"rel="stylesheet">
</head>

<body class="text-tet">
    <!-- navbar top -->
    <div class="px-16 py-4 shadow-nav flex justify-between w-full bg-white z-10 fixed top-0">
        <h1 class="text-xl font-bold text-blue-dark">
            StarBhak</h1>
        <div class="flex">
            <p class="py-1 mr-2 font-semibold">
                User |</p>
            <button class="bg-blue-dark text-white px-2 py-1 rounded ">
                Log Out</button>
        </div>
    </div>

    <!-- Sidebar left -->
    <div class="px-14 py-20 shadow-side w-fit h-[100vh] top-16 fixed">
        <a href="/">
            <div class="text-unselect"><span class="material-symbols-outlined -mb-3 mr-5">home</span>
                Dashboard
            </div>
        </a>
        <a href="/absensiswa">
            <div class="mt-10 text-unselect"><span class="material-symbols-outlined -mb-3 mr-5">library_books</span>
                Absen
            </div>
        </a>
        <a href="/datasiswa">
            <div class="font-semibold mt-10"><span class="material-symbols-outlined -mb-3 mr-5">assignment_ind</span>
                Data Siswa
            </div>
        </a>
        <div class="mt-10 text-unselect"><span class="material-symbols-outlined -mb-3 mr-5">sms_failed</span>
            Laporan
        </div>
    </div>

    <!-- content -->
    <div class="absolute left-72 w-3/4">
        <h1 class="text-3xl text-blue font-bold mt-32 font-[Montserrat]">Daftar Siswa</h1>
        <a href="/datasiswa/tambah">
            <button class="bg-blue text-white py-2 px-4 rounded-xl mt-5 w-fit mx-auto font-semibold">+ Buat</button>
        </a>
        <!-- onclick="keiAlert('Data Berhasil Disimpan')" -->
        <!-- table -->
        <div class="h-96 overflow-auto mt-5">
            <table class="w-full font-[Montserrat]">
                <thead class="text-blue-table bg-white font-extrabold text-xl shadow-stable top-0 sticky z-10">
                    <tr class="">
                        <th class="p-3">NO</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Kelas</th>
                        <th class="p-3">NISN</th>
                        <th class="p-3">Jenis Kelamin</th>
                        <th class="p-3">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    {% for item in data %}
                        <tr class="text-center border-tet-x border-t-0 border-l-0 border-r-0 border-[1px] border-solid hover:font-bold cursor-pointer">
                            <td class="p-3">no</td>
                            <td class="p-3">{{item[1]}}</td>
                            <td class="p-3">{{item[2]}}</td>
                            <td class="p-3">{{item[3]}}</td>
                            <td class="p-3">{{item[4]}}</td>
                            <td class="p-3">
                                <a href="">
                                    <span class="material-symbols-outlined -mb-3 mr-5">edit</span>
                                </a> 
                                <a href="">
                                    <span class="material-symbols-outlined -mb-3 mr-5">folder</span>
                                </a>
                            </td>
                        </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
<!-- custom alert -->
    <script src="../static/assets/JS/cstkei.alert.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let lastcnt = 0;
            let cnt;
            chkNewScan();

            function chkNewScan() {
                countTodayScan();
                setTimeout(chkNewScan, 1000);
            }

            function countTodayScan() {
                $.ajax({
                    url: '/countTodayScan',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        cnt = data.rowcount;
                        if (cnt > lastcnt) {
                            reloadTable();
                        }
                        lastcnt = cnt;
                    },
                    error: function (result) {
                        console.log('no result!')
                    }
                })
            }

            function reloadTable() {
                $.ajax({
                    url: '/loadData',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var tr = $("#totalabsen");
                        tr.empty();
                        $.each(response, function (index, item) {
                            inc = 1
                            if (item.length > 0) {
                                for (let i = 0; i < item.length; i++) {
                                    tr.append('<tr class="text-center border-tet-x border-t-0 border-l-0 border-r-0 border-[1px] border-solid hover:font-bold cursor-pointer p-3">' +
                                        '<td class="p-3">' + inc + '</td>' +
                                        '<td class="p-3">' + item[i][2] + '</td>' +
                                        '<td class="p-3">' + item[i][3] + '</td>' +
                                        '<td class="p-3">' + item[i][4] + '</td>' +
                                        '<td class="p-3">' + item[i][5] + '</td>' +                                    
                                        '<td class="p-3">' + item[i][6] + '</td>' +
                                    '</tr>');
                                    inc++
                                }
                            }
                        });
                    },
                    error: function (result) {
                        console.log('no result!')
                    }
                });
            }
        });
    </script>
</body>
</html>

<!-- npx tailwindcss -i ./src/input.css -o ./public/assets/css/output.css --watch -->