const dropArea = $(".drag-area")
const dragText = $(".h5")

dropArea.on("dragover", (event) => {
  event.preventDefault()
  dropArea.addClass("active")
  dragText.text("Release to Upload File")
})

// Event saat drag di luar dropArea
dropArea.on("dragleave", () => {
  dropArea.removeClass("active")
  dragText.text("Drag & Drop to Upload File")
})

// Event saat telah drop file/image di dropArea
dropArea.on("drop", (event) => {
  event.preventDefault()
  file = event.originalEvent.dataTransfer.files[0]
  showFile()
})

$('#inputGroupFile01').on("change", function(){
  file = this.files[0];
  showFile()
  dropArea.addClass("active")
})

function hapus(){
  let imgTag = 
  `
    <div class="container-petunjuk">
      <i class="fa fa-cloud-upload icon"></i>
      <p class="h5">Drag & Drop to Upload File</p>
    </div>
  `
  dropArea.html(imgTag)
}

// Function untuk menampilkan file di dropArea
let showFile = () => {
  let fileType = file.type

  let validExtensions = ["image/jpeg", "image/jpg", "image/png"]
  if(validExtensions.includes(fileType)){
    let fileReader = new FileReader()
    fileReader.onload = () => {
        let fileURL = fileReader.result
        if($('.img-tag').length == 0){
          let imgTag = `
            <img src="${fileURL}" alt="" class="img-tag">`
        
          dropArea.html(imgTag)
        } else {
          $('.img-tag').attr('src', fileURL)
        }
    }
    $('.btn-checkout').attr('disabled', false)
    $('.btn-hapus').attr('disabled', false)
    fileReader.readAsDataURL(file)
  } else {
    alert("This is not an Image File")
    dropArea.classList.remove("active")
  }
}
