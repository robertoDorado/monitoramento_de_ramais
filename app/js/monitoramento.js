// $.ajax({
//     url: "http://l5d1137.callbox.com.br/monitoramento/lib/ramais.php",
//     type: "GET",
//     success: function(data){                
//         for(let i in data){
//             $('#cartoes').append(`<div class="cartao">
//                                 <div>${data[i].nome}</div>
//                                 <span class="${data[i].status} icone-posicao"></span>
//                               </div>`)
//         }
        
//     },
//     error: function(){
//         console.log("Errouu!")
//     }
// });

// Requisição Ajax dos ramais em Javascript

const xhr = new XMLHttpRequest

xhr.onreadystatechange = () => {
    let dataOperadorArray = []
    let dataNomeArray = []
    let dataStatusArray = []
    let dataOnlineArray = []
    
    if(xhr.readyState == 4 && xhr.status == 200){
        
        const objectRamais = JSON.parse(xhr.response)
        
        const idCartoes = document.querySelector("#cartoes")

        for(let i in objectRamais){

            const divCartao = document.createElement('div')
            const divNome = document.createElement('div')
            const spanStatus = document.createElement('span')
            const spanOperador = document.createElement('operador')

            idCartoes.append(divCartao)
            divCartao.append(divNome)
            divCartao.append(spanStatus)
            divCartao.append(spanOperador)

            divCartao.setAttribute('class', 'cartao')
            spanStatus.setAttribute('class', `${objectRamais[i].status} icone-posicao`)

            divNome.innerHTML = objectRamais[i].nome
            spanOperador.innerHTML = objectRamais[i].operador

            if(dataOperadorArray.indexOf() <= -1){
                dataOperadorArray.push(objectRamais[i].operador)
            }

            if(dataNomeArray.indexOf() <= -1){
                dataNomeArray.push(objectRamais[i].nome)
            }

            if(dataStatusArray.indexOf() <= -1){
                dataStatusArray.push(objectRamais[i].status)
            }

            if(dataOnlineArray.indexOf() <= -1){
                dataOnlineArray.push(objectRamais[i].online)
            }

            
            if(objectRamais[i].status == "indisponivel"){
                
                divCartao.classList.add('cartao-indisponivel')
            }
        }
    }

    // Requisição Ajax Post

    const xhrPost = new XMLHttpRequest
    const formData = new FormData
    let newDataOnlineArray = []

    dataOnlineArray.map(($item) => {
        if($item == true){
            newDataOnlineArray.push(1)
        }
        if($item == false){
            newDataOnlineArray.push(0)
        }
    })
    
    formData.append('arrayNome', dataNomeArray)
    formData.append('arrayOperador', dataOperadorArray)
    formData.append('arrayStatus', dataStatusArray)
    formData.append('arrayOnline', newDataOnlineArray)
    
    window.addEventListener('load', () => {
            
            xhrPost.onreadystatechange = () => {
                
                if(xhrPost.status == 200 && xhrPost.readyState == 4){
        
                    console.log(xhrPost.response)
                }
            }
            xhrPost.open('POST', 'app/lib/update-ramais.php')
            xhrPost.send(formData)
        })


    // Requisição Ajax Post
}

xhr.open('GET', 'app/lib/ramais.php')
xhr.send()