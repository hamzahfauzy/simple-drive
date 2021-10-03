<?php load('partials/top') ?>
<div id="modal" class="fixed top-0 left-0 bg-black bg-opacity-50 transform scale-0 overflow-y-scroll z-10 flex items-center">
    <!-- Modal content -->
    <div class="bg-white shadow-lg w-9/12 mx-auto p-12">
        <!--Close modal button-->
        <button id="closebutton" type="button" class="focus:outline-none absolute top-4 right-6" onclick="closeModal()">
            <!-- Hero icon - close button -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
        <!-- Test content -->

        <div>
            <div class="upload-form text-center lg:max-w-screen-lg mx-auto border-4 hover:border-indigo-600 p-8 border-dashed" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
                <input id="uploadField" name="uploadField" type="file" class="hidden" onchange="uploadFile(this.files[0])"/>
                <button class="p-2 bg-blue-800 text-white rounded px-4" onclick="uploadField.click()"><i class="fa fa-plus"></i> Upload File</button>
                <br>
                <small>Atau</small>
                <br>
                Seret file file ke sini
            </div>

            <div class="progress hidden">
                <label id="upload-label">Mengupload file..</label>
                <progress min="0" max="100" class="w-full"></progress>
                <label id="progress-label"></label>
                <div class="flex space-x-3">
                    <div class="flex-none w-1/3 flex justify-center items-center">
                        <h2 class="text-9xl text-center" id="uploaded-icon">
                            <i class="fa fa-ghost"></i>
                        </h2>
                    </div>    
                    <form action="" method="post" onsubmit="return saveFile()" class="flex-1">
                        <input type="hidden" name="file_name" id="file_name">
                        <div class="form-group mb-2">
                            <label for="" class="w-full">Nama</label>
                            <input type="text" name="nama" id="" class="w-full border p-2">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="w-full">Kategori</label>
                            <input type="text" name="kategori" id="" class="w-full border p-2">
                        </div>
                        <button class="p-2 bg-blue-800 text-white rounded px-4">Simpan</button>
                        <button class="p-2 bg-red-800 text-white rounded px-4" onclick="closeModal()">Tutup</button>
                    </form>
                </div>
                <!-- <div class="reupload hidden">
                    <button class="p-2 bg-blue-800 text-white rounded px-4 hidden" onclick="reupload()">Upload Lagi</button>
                </div> -->
            </div>

        </div>
    </div>
</div>

<div class="content content-file-anda hidden lg:max-w-screen-lg lg:mx-auto mx-6 pt-8 pb-8">
    <h2 class="text-xl mb-4 mx-2">File Anda</h2>
    <div class="grid grid-cols-3 gap-4 file_anda"></div>
    <div class="fab">
        <a href="javascript:void(0)" onclick="openModal()" class="rounded-full shadow-lg p-0 w-12 h-12 bg-indigo-800 text-white fixed right-10 bottom-10 text-xl text-center" style="line-height: 48px;"><i class="fa fa-plus"></i></a>
    </div>
</div>

<div class="content content-tidak-ada-file flex items-center" style="min-height:calc(100vh - 58px);height:auto;">
    <div class="text-center lg:max-w-screen-lg mx-auto">
        <h1 class="text-5xl opacity-50 mb-2">Belum ada file</h1>
        <button class="p-2 bg-blue-800 text-white rounded px-4" onclick="openModal()">Klik untuk mengupload file</button>
    </div>
</div>

<script>
function openModal()
{
    var modal = document.getElementById('modal')
    modal.classList.add('transition-transform')
    modal.classList.add('duration-300')
    modal.classList.add('scale-100')
    modal.classList.add('w-screen')
    modal.classList.add('h-screen')
    reupload()
}

function closeModal()
{
    var modal = document.getElementById('modal')
    modal.classList.remove('scale-100')
    location.reload()
}

function uploadFile(file){
    var c = confirm('Apakah anda yakin akan mengupload file ini ?')
    if(!c) return
	// alert(file.name+" | "+file.size+" | "+file.type);
    document.querySelector('#upload-label').innerHTML = "Mengunggah "+file.name+"..."
    document.querySelector('.upload-form').classList.add('hidden')
    document.querySelector('.progress').classList.remove('hidden')
	var formdata = new FormData();
	formdata.append("file", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "?action=upload");
	ajax.send(formdata);
}
function progressHandler(event){
	document.querySelector("#progress-label").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	document.querySelector("progress").value = Math.round(percent);
}
function completeHandler(event){
    var response = JSON.parse(event.target.responseText)
    document.querySelector('#upload-label').innerHTML = response.msg
	document.querySelector("#progress-label").innerHTML = "";
	document.querySelector("progress").value = 100;
    if(response.hasOwnProperty('mime'))
    {
        document.querySelector('#uploaded-icon').innerHTML = '<i class="fa fa-'+response.mime+'"></i>'
        document.querySelector('[name=file_name]').value = response.filename
        document.querySelector('[name=nama]').value = response.original_name

        var formData = new FormData;
        formData.append('file_name',response.filename)
        formData.append('name',response.original_name)
        formData.append('kategori','NONE')
        insert(formData)
    }
    // document.querySelector(".reupload").classList.remove('hidden')
}
function errorHandler(event){
	document.querySelector("#progress-label").innerHTML = "Upload Failed";
}
function abortHandler(event){
	document.querySelector("#progress-label").innerHTML = "Upload Aborted";
}

function reupload(){
    document.querySelector(".upload-form").classList.remove('hidden')
    document.querySelector(".progress").classList.add('hidden')
    document.querySelector(".reupload").classList.add('hidden')
    document.querySelector('[name=file_name]').value = ""
}

function dropHandler(ev) {
  ev.preventDefault();
  uploadFile(ev.dataTransfer.files[0])
}

// only react to actual files being dragged
function dragEnterHandler(e) {
  e.preventDefault();
}

function dragLeaveHandler(e) {
}

function dragOverHandler(e) {
    e.preventDefault();
}

function hapus(ori, file_name)
{
    var c = confirm('Apakah anda yakin akan menghapus file ini ?')
    if(!c) return

    fetch('<?=API_URL?>drive/hapus',{
        method:'POST',
        headers:{
            'Authorization': 'Bearer <?=$_SESSION['auth']['token']?>',
            'Content-Type':'application/x-www-form-urlencoded'
        },
        body:'file_name='+ori
    })
    .then(res => res.json())
    .then(res => {
        if(res.msg == 'sukses')
        {
            alert('File '+file_name+' Berhasil di hapus')
            location.reload()
        }
        else
            alert('File '+file_name+' Gagal di hapus')
    })
}

async function insert(formdata, show_alert = false)
{
    var req = await fetch('<?=API_URL?>drive/insert',{
        method:'POST',
        headers:{
            'Authorization':'Bearer <?=$_SESSION['auth']['token']?>'
        },
        body:formdata
    })
    var res = await req.json()
    if(show_alert)
    {
        if(res.msg == 'sukses')
        {
            alert('File '+res.file_name+' Berhasil di simpan')
        }
        else
            alert('File '+res.file_name+' Gagal di simpan')
    }
}

async function saveFile()
{
    event.preventDefault();
    var formData = new FormData;
    formData.append('file_name',document.querySelector('[name=file_name]').value)
    formData.append('name',document.querySelector('[name=nama]').value)
    formData.append('kategori',document.querySelector('[name=kategori]').value)
    await insert(formData,1)
    location.reload()
    return false
}

function copyUrl(el) {
  var copyText = document.getElementById(el);
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);

  setTimeout(e => {
      alert('Link berhasil disalin')
  },100)
}

async function init()
{
    var req_file = await fetch('<?=API_URL?>drive/index',{
        headers:{
            Authorization: 'Bearer <?=$_SESSION['auth']['token']?>'
        }
    })

    if(req.status == 401)
    {
        location='?action=auth/logout'
        return
    }

    var res_file = await req_file.json();
    if(res_file.length)
    {
        var file_lists = ''
        res_file.forEach(f => {
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(f.nama)[1]; 
            var id  = f.id
            var file_url = "<?=url()?>/index.php?action=show&file="+f.file_name+"&id="+f.user_id; //storage/".$_SESSION['auth']['username']."/".$file;
        
        file_lists += `<figure class="bg-white rounded-xl p-4 m-2">
            <div class="bg-gray-100 rounded-xl p-8">
                <h2 class="text-9xl text-center">
                    <i class="fa fa-file"></i>
                </h2>
            </div>
            <div class="pt-4 text-center md:text-left break-words">
                <a href="${file_url}" target="_blank" class="text-indigo-800">${f.nama}</a><br>
                <span class="text-xs text-grey-400">Diupload pada ${f.created_at}</span>
                <div class="clear-both"></div>
                <a href="javascript:void(0)" onclick="copyUrl('url-${id}')" class="bg-green-800 hover:bg-green-600 text-white px-3 py-2 rounded text-xs inline-block mb-1"><i class="fa fa-link"></i> Salin URL</a>
                <a href="${file_url}" class="bg-blue-800 hover:bg-blue-600 text-white px-3 py-2 rounded text-xs inline-block mb-1"><i class="fa fa-download"></i> Unduh</a>
                <a href="javascript:void(0)" onclick="hapus('${f.file_name}','${f.nama}')" class="bg-red-800 hover:bg-red-600 text-white px-3 py-2 rounded text-xs inline-block mb-1">Hapus</a>
                <input type="text" class="opacity-0" value="${file_url}" id="url-${id}">
            </div>
        </figure>`
        })

        document.querySelector('.content-file-anda').classList.toggle('hidden')
        document.querySelector('.content-tidak-ada-file').classList.toggle('hidden')
        document.querySelector('.file_anda').innerHTML = file_lists
    }
}

init()
</script>
<?php load('partials/bottom') ?>
