async function fetchLatestLogData() {
    try {
        const response = await fetch('http://localhost:88/api/logs');
        if (!response.ok) {
            throw new Error(`Erro ao buscar dados: ${response.status}`);
        }
        const data = await response.json();
        mensagem_erro = document.getElementById("mensagemErro");
        mensagem_erro.style.display = 'none';
        updateLogsDisplay(data);
    } catch (error) {
        console.error("Erro ao buscar os dados mais recentes:", error);
        mensagem_erro = document.getElementById("mensagemErro");
        mensagem_erro.style.display = 'flex';
    }
}

LogsArray = []

function updateLogsDisplay(data) {
    deleteLogs();
    count = Object.keys(data).length
    tabela = document.getElementById("Tabela_logs");
    tabela.style.display = 'table';
    for (let i = 0; i < count; i++)
    {
        if(!LogsArray.includes(data[i].log_id))
        {
            var table = document.getElementById("Tabela_logs");
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = data[i].log_id;
            cell2.innerHTML = data[i].tipo_sensor;
            if (data[i].tipo_sensor == 'Temperatura interna' || data[i].tipo_sensor == 'Temperatura externa')
            {
                cell3.innerHTML = data[i].valor + "°C";
            }
            else
            {
                cell3.innerHTML = data[i].valor + "%";
            }
            cell4.innerHTML = data[i].data_log;
            LogsArray.push(data[i].log_id)
        }
    }
}
function deleteLogs()
{
    tabela = document.getElementById("Tabela_logs");
    linhas = tabela.rows.length
    for(i = 1; i<linhas; i++)
    {
        tabela.deleteRow(-1);
    }
}
function printdata()
{
    date = document.getElementById('header_data');
    getLogsData(date.value);
    console.log(date.value);
}

async function getLogsData(data) {
    let url = "http://localhost:88/api/logs/" + data;
    try {
        mensagem_erro = document.getElementById("mensagemErro");
        mensagem_erro.style.display = 'none';
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        mensagem_erro = document.getElementById("mensagemErro");
        mensagem_erro.style.display = 'none';
        const data = await response.json();
        LogsArray = []
        updateLogsDisplay(data);
        return data;
    } catch (error) {
        deleteLogs()
        tabela = document.getElementById("Tabela_logs");
        tabela.style.display = 'none';
        mensagem_erro = document.getElementById("mensagemErro");
        mensagem_erro.style.display = 'flex';
        console.error(error.message);
    }
}



function goto_index()
{
    window.location.replace("./index.html");
}