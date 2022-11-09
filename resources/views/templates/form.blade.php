<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Daftar | Starbhak Absensi</title>
    <!-- css link -->
    <link rel="stylesheet" href="../static/assets/CSS/output.css">
    <link rel="stylesheet" href="../static/assets/CSS/suport.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- font montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,500&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- cdn tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;1,500&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue-dark': '#1061FF',
                        'blue': '#349DFD',
                        'tet': '#001458',
                        'unselect': '#BAC5E7',
                        'stroke': '#81B7E9',
                        'h1': '#1A91FF',

                    },
                    boxShadow: {
                        nav: '2px 2px 50px 1px rgba(179, 185, 191, 0.1);',
                        bxsd: '5px 5px 10px rgba(0, 0, 0, 0.1);',
                        side: ' 0px 5px 10px rgba(0, 0, 0, 0.05);',
                    }
                },
            }
        }
    </script>

</head> 

<body class="text-tet">
    <div class="px-16 py-4 shadow-nav flex justify-between w-full bg-white z-10 fixed top-0">
        <h1 class="text-xl font-bold text-blue-dark">
            StarBhak</h1>
        <div class="flex">
            <p class="py-1 mr-2 font-semibold">
                User |</p>
            <button class="bg-blue-dark text-white px-2 py-1 rounded ">
                Log Out
            </button>
        </div>
    </div>
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
    <div class="absolute left-64 w-3/5 bg-white h-fit mt-32 ml-32 rounded-xl shadow-bxsd pb-12  ">
        <h1 class="text-xl ml-24 text-h1 font-bold mt-10 mb-2 font-['Montserrat']">Tambah Data Siswa</h1>
        <div class="border-b-blue border-2 w-10/12 mx-auto"></div>
        <main class="mx-auto mt-5 w-4/5 text-base ">
            <form class="mx-auto item-center flex flex-col" method="post" action="/addprsn_submit">
                <h2 for="" class="font-['Quicksand'] font-semibold text-tet text-ms">Silahkan Isi Data Terlebih Dahulu</h2>
                <input type="hidden" name="id" placeholder="id" class=" text-center border-2 border-blue-dark border-opacity-40 rounded-md w-3/4 mt-4 h-8 mx-auto" value={{ newnbr }}>
                <input type="text" name="nama" id="nama-siswa" placeholder="Nama Siswa" class=" text-center border-2 border-blue-dark border-opacity-40 rounded-md w-3/4 mt-4 h-8 mx-auto" required>
                <p id="err-1" class="font-['Quicksand'] font-semibold mx-auto text-red-600"></p>
                <select class="text-center border-2 border-blue-dark border-opacity-40 rounded-md mx-auto w-3/4 mt-3 h-8" required name="kelas">
                    <option value="">Kelas</option>
                    <option value="XI-PPLG 1">XI-PPLG 1</option>
                    <option value="XI-PPLG 2">XI-PPLG 2</option>
                </select>
                <select class="text-center border-2 border-blue-dark border-opacity-40 rounded-md mx-auto w-3/4 mt-3 h-8" required name="jkelamin">
                    <option value="">Jenis Kelamin</option>
                    <option value="Laki Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <input type="number" placeholder="NISN" class="text-center border-2 border-blue-dark border-opacity-40 rounded-md mx-auto w-3/4 mt-3 h-8" required name="nisn">
                <p id="err-2" class="font-['Quicksand'] font-semibold mx-auto text-red-600"></p>
    
                <input type="submit" id="btn-1" class="text-center bg-gray-400 text-base text-white rounded-md mx-auto w-3/4 mt-3 h-8" value="Pindai Wajah">
            </form>
        </main>
    </div>
    <script src="https://codepen.io/kan327/pen/PoaZWxe"></script>      
    <script type="text/javascript">
        //buat live count
    </script>
</body>
</html>