
function controlChips(){
    let aposta = document.getElementById('bet')
    const myChips = parseInt(document.getElementById('chips').textContent);
    if(isNaN(aposta.value)){
        alert("Escriu numeros")
        aposta.value = ""
    }else if(aposta.value > myChips){
        alert("No tens tantes fitxes")
        aposta.value = ""
    }
}
function controlAposta(){
    let numero = document.getElementById('bet-number')
    let tipusAposta = document.getElementById('bet-type').value
    if(numero.value == ""){
        return true
    }
    if(isNaN(numero.value)){
        alert("Escriu numeros")
        numero.value = ""
        return false
    }else if(numero.value > 36 || numero.value < 0){
        alert("No existeix aquest numero a la ruleta")
        numero.value = ""
        return false
    }else if(numero.value %2 != 0 && tipusAposta == 'parell'){
        alert(`El ${numero.value} no es un numero parell`)
        numero.value = ""
        return false
    }else if(numero.value %2 == 0 && tipusAposta == 'imparell'){
        alert(`El ${numero.value} no es un numero imparell`)
        numero.value = ""
        return false
    }
    return true
}

document.getElementById('botoGirar').addEventListener('click',()=>{
    document.getElementById("botoGirar").disabled = true;
    let chipsAposta = document.getElementById('bet').value
    let tipusAposta = document.getElementById('bet-type')
    let numberAposta = document.getElementById('bet-number')
    let myChips = Number(document.getElementById('chips').textContent);
    
    if(chipsAposta == ""){
        alert("Aposta algo")
        document.getElementById("botoGirar").disabled = false;
        return 
    }
    if(!controlAposta()){
        document.getElementById("botoGirar").disabled = false;
        return
    }

    let millisecondsToWait = 100;
    for (let i = 0; i < 30; i++) {
        millisecondsToWait += 50
        timeOut(millisecondsToWait)
    }

    setTimeout(function() {
        let msgAlert
        let numberAle = testerControl(tipusAposta.value, numberAposta.value)
        const p = document.getElementById('result')
        p.innerHTML = numberAle
        let xipsTotals
        let perdut
        if(numberAle %2 == 0 ){
            if(tipusAposta.value == 'parell'){
                xipsTotals = (chipsAposta/2)
                perdut = false
                msgAlert = `Has encertat, es parell! `
            }else{
                xipsTotals =  chipsAposta
                perdut = true
                msgAlert = `Has fallat, es parell! `
            }
        }else{
            if(tipusAposta.value == 'imparell'){
                xipsTotals = (chipsAposta/2)
                perdut = false
                msgAlert = `Has encertat, es imparell! `
            }else{
                xipsTotals =  chipsAposta
                perdut = true
                msgAlert = `Has fallat, es imparell!`
            }
        }
        if(numberAle == numberAposta.value){
            msgAlert += " I has encertat el numero!!"
            xipsTotals =  (chipsAposta*2)
        }else if(numberAle != "" && numberAposta.value != ""){
            msgAlert += " Pero no has encertat el numero!!"
        }
        setTimeout(function() {
            msgAlert += perdut ? ` Has perdut ${(Math.floor(xipsTotals))} chips`: ` Has guanyat ${(Math.floor(xipsTotals))} chips`
            //document.cookie = `myChips=${xipsTotals}`
            alert(msgAlert)
            const add = document.getElementById("add-chips")
            add.value = perdut ? -(Math.floor(xipsTotals)):(Math.floor(xipsTotals)) ;
            document.getElementById("add-chips-btn").click();
            
            numberAposta.value = ""
            document.getElementById("botoGirar").disabled = false;
        }, 100);
        
    }, 1650);
})

function timeOut(millisecondsToWait){
    const p = document.getElementById('result')
    setTimeout(function() {
        const numero = Math.floor(Math.random() * 31)
        p.innerHTML = numero ;
    }, millisecondsToWait);
    
}

function testerControl(tipusAposta , numberAposta){
    let test = document.getElementById('test-mode').value
    let numAle = 0
    switch (test) {
        case "test-win":
            if(tipusAposta == 'parell'){
                numAle = getNumParell()
            }else{
                numAle = getNumImpar()
            }
            if(numberAposta != ""){
                numAle = numberAposta
            }
            break;
        case "test-loose":
            if(tipusAposta == 'parell'){
                numAle = getNumImpar()
            }else{
                numAle = getNumParell()
            }
            break;
        default:
            numAle = Math.floor(Math.random() * 31);
    }
    return numAle
}

function getNumParell(){
    let numAle = 0
    do{
        numAle = Math.floor(Math.random() * 31)
    }while(numAle%2!=0)
    return numAle
}
function getNumImpar(){
    let numAle = 0
    do{
        numAle = Math.floor(Math.random() * 31)
    }while(numAle%2==0)
    return numAle
}