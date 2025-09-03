setInterval(fetchLatestSensorData, 1000);

async function getDataManual(id) {
    let url = "http://localhost:88/api/controlemanual/" + id;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error(error.message);
    }
}
async function getAllDataManual() {
    let url = "http://localhost:88/api/controlemanual/";
    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const data = await response.json();
    } catch (error) {
        console.error(error.message);
    }

}

async function getAllDataManual() {
    let url = "http://localhost:88/api/log/";
    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const data = await response.json();
    } catch (error) {
        console.error(error.message);
    }

}

const apiBaseUrl = "http://localhost:88/api/sensors";

async function fetchLatestSensorData() {
    try {
        const response = await fetch(`${apiBaseUrl}`);
        if (!response.ok) {
            throw new Error(`Erro ao buscar dados: ${response.status}`);
        }
        const data = await response.json();
        updateSensorDisplay(data);
    } catch (error) {
        console.error("Erro ao buscar os dados mais recentes:", error);
    }
}

function updateSensorDisplay(data) {
    const sensorDataElements = document.querySelectorAll(".sensor-data");
    try {
        sensorDataElements[0].textContent = `${data[0].valor || 0}°C`; // Temperatura Interna
        sensorDataElements[1].textContent = `${data[1].valor || 0}°C`; // Temperatura Externa
        sensorDataElements[2].textContent = `${data[4].valor || 0}%`; // Água
        sensorDataElements[3].textContent = `${data[2].valor || 0}%`; // Umidade
    } catch(error) {
        console.error("Elementos .sensor-data não encontrados no DOM.");
    }
    try
    {
        document.getElementById('inner_bar_externa').style.marginRight = `${(((100 - (Number(data[1].valor)))/100)*290)}px`;
        document.getElementById('inner_bar_humidity').style.marginRight = `${(((100 - (Number(data[2].valor)))/100)*290)}px`;
        document.getElementById('inner_bar_interna').style.marginRight = `${(((100 - (Number(data[0].valor)))/100)*290)}px`;
        document.getElementById('level_indicator').style.marginTop = `${(((100 - (Number(data[4].valor)))/100)*290)}px`;
        
    }
    catch(error)
    {
        console.log(Number(data[2].valor))
    }
}

document.addEventListener("DOMContentLoaded", fetchLatestSensorData);


async function setup() {
    document.getElementById("servo").classList.add("off");
    document.getElementById("lampada").classList.add("off");
    document.getElementById("helice").classList.add("off");
}

const rodar =
    [
        { transform: "rotate(360deg)" }
    ];
const rodarduracao = {
    duration: 800,
    iterations: Infinity,
};

function goto_logs()
{
    window.location.replace("./logs.html");
}


let animacao = null;

async function rotate_helice() {
    animacao = document.getElementById("helice").animate(rodar, rodarduracao);
    document.getElementById("helice").classList.replace("off", "on");

    let _helice_data = {
        controle: "ventilacao",
        atividade: 1
    }
      
    await fetch('http://localhost:88/api/controlemanual/1', {
    method: "PUT",
    body: JSON.stringify(_helice_data),
    headers: { 'Content-Type': 'application/json' }
    })
    
    let data = await getDataManual(1);
    console.log(data)
}

async function helice_off() {
    if (animacao) {
        animacao.cancel(); // Cancela a animação se ela estiver em andamento
    }
    document.getElementById("helice").classList.replace("on", "off");
    let _helice_data = {
        controle: "ventilacao",
        atividade: 0
    }
      
    await fetch('http://localhost:88/api/controlemanual/1', {
    method: "PUT",
    body: JSON.stringify(_helice_data),
    headers: { 'Content-Type': 'application/json' }
    })
    
    let data = await getDataManual(1);
    console.log(data)
}

async function lampada_on() {
    document.getElementById("lampada").classList.replace("off", "on");
    let _lampada_data = {
        controle: "Lampada",
        atividade: 1
    }
      
    await fetch('http://localhost:88/api/controlemanual/3', {
    method: "PUT",
    body: JSON.stringify(_lampada_data),
    headers: { 'Content-Type': 'application/json' }
    })
    
    let data = await getDataManual(3);
    console.log(data)
}
async function lampada_off() {

    document.getElementById("lampada").classList.replace("on", "off");
    let _lampada_data = {
        controle: "Lampada",
        atividade: 0
    }
      
    await fetch('http://localhost:88/api/controlemanual/3', {
    method: "PUT",
    body: JSON.stringify(_lampada_data),
    headers: { 'Content-Type': 'application/json' }
    })
    
    let data = await getDataManual(3);
    console.log(data)
}


async function servo_on() {

    document.getElementById("servo").classList.replace("off", "on");
    
    let _data = {
        controle: "servomotor",
        atividade: 1
    }
      
    await fetch('http://localhost:88/api/controlemanual/4', {
    method: "PUT",
    body: JSON.stringify(_data),
    headers: { 'Content-Type': 'application/json' }
    })
    
    let data = await getDataManual(4);
    console.log(data)
}
async function servo_off() {
    document.getElementById("servo").classList.replace("on", "off");
    
    let _data = {
        controle: "servomotor",
        atividade: 0,
    }
      
    await fetch('http://localhost:88/api/controlemanual/4', {
    method: "PUT",
    body: JSON.stringify(_data),
    headers: { 'Content-Type': 'application/json' }
    })
    let data = await getDataManual(4);
    console.log(data)
}


    