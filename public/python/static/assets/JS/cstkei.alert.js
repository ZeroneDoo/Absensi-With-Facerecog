console.log("%c" + "CSTKEi ALERT", "color: #7289DA; -webkit-text-stroke: 2px black; font-size: 72px; font-weight: bold;");
// keiAlert('Data Berhasil Ditambahkan')
// keiAlert('Data Gagal Ditambahkan', 'cancel', 'bg-red-600')

function keiAlert(messege, icon='done', color='bg-blue-dark'){
    var oldAlt = document.getElementById("p1");
    var alt2 = document.getElementById("p2");
    if(document.body.contains(alt2)){

    }else if(document.body.contains(oldAlt)){
        document.body.innerHTML += '<div id="p2" class="animated-up absolute py-3 px-5 left-[75%] top-40 flex justify-between w-72 h-12 bg-red-600 rounded "><p class="text-white">Mohon lihat Pesan Diatas!</p><span class="material-symbols-outlined text-white">warning</span></div>'
        var box1 = document.getElementById('p2')
        setTimeout(bo1d, 4000)
        function bo1d(){
            box1.classList.add("animated-down");
        }
        setTimeout(rem1d, 5000)
        function rem1d(){
            box1.remove();
        }
    }else{
        document.body.innerHTML += '<div id="p1" class="animated-up absolute py-3 px-5 left-[75%] top-20 flex justify-between w-72 h-12 '+color+' rounded "><p class="text-white">'+messege+'</p><span class="material-symbols-outlined text-white">'+icon+'</span></div>'
        var box2 = document.getElementById('p1')
        setTimeout(bo2d, 4000)
        function bo2d(){
            box2.classList.add("animated-down");
        }
        setTimeout(rem2d, 5000)
        function rem2d(){
            box2.remove();
        }
    }
    var box1 = document.getElementById('p2')
    var box2 = document.getElementById('p1')
        setTimeout(ani, 4000)
        function ani(){
            box1.classList.add("animated-down");
            box2.classList.add("animated-down");
        }
        setTimeout(rem, 5000)
        function rem(){
            box1.remove();
            box2.remove();
        }
}