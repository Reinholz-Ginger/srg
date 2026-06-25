<?php
include '../../generalPhp/conection.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die(header("Location: ../../index.php"));
}

if (isset($_GET['id']) && isset($_GET['nome'])) {
    $id = $_GET['id'];
    $nome = $_GET['nome'];
    $numero_container = $_GET['numero_container'] ?? '';

    // Verifica se o registro existe em pre_embarque
    $stmt = $conn->prepare("SELECT * FROM pre_embarque WHERE uniqId = ?");
    $stmt->bind_param("s", $id);

    if (!$stmt->execute()) {
        die("Erro ao executar consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Nenhum registro encontrado
        die("Registro de pré-embarque não encontrado.");
    }

    // Coleta os dados salvos em pre_embarque_files
    $dadosCampos = [];
    $stmtCampos = $conn->prepare("SELECT nomeCampo, caminho, resposta FROM pre_embarque_files WHERE uniqId = ?");
    $stmtCampos->bind_param("s", $id);
    $stmtCampos->execute();
    $resultCampos = $stmtCampos->get_result();

    while ($row = $resultCampos->fetch_assoc()) {
        $nomeCampo = $row['nomeCampo'] ?? '';
        if (trim($nomeCampo) !== '') {
            $dadosCampos[$nomeCampo] = [
                'caminho' => $row['caminho'] ?? '',
                'resposta' => $row['resposta'] ?? ''
            ];
        }
    }
} else {
    // Redireciona se parâmetros obrigatórios não forem passados
    header("Location:../preEmbarque.php");
    exit;
}


?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <meta name="robots" content="nofollow,noindex">
    <script src="../../generalScripts/darkmode.js?v=1.7.1"></script>
    <title>Pre Embarque</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <link rel="shortcut icon" href="../../assets/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../../onLoad/onLoad.css?v=1.7.1">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="../../generalScripts/darkmode.js?v=1.7.1"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen" onload="onLoad()">

    <div id="loader" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="w-16 h-16 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
    </div>


    <!-- Preloader -->
    <div class="overflow white" id="preload">
        <div class="circle-line">
            <div class="circle-red"></div>
            <div class="circle-blue"></div>
            <div class="circle-green"></div>
            <div class="circle-yellow"></div>
        </div>
    </div>
    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-green-700 dark:bg-green-800 text-white">
        <button id="btnVoltar" title="Voltar">
            <img src="../../assets/backArrow.svg" alt="Voltar" class="w-6 h-6">
        </button>

        <div class="text-center flex-1">
            <h3 class="text-lg font-semibold"><?= $nome ?> </h3>
        </div>
        <button onclick="toggleTheme()" title="Alternar tema" class="z-10 text-xl w-10 h-10 text-yellow-500 hover:text-yellow-400 transition">
            <i class="fas fa-circle-half-stroke"></i>
        </button>
        <div>

            <!-- <a href="../listarPedido/print/printInspessao.php?id=<?= $id ?>&numero=<?= $numero ?>&cliente=<?= $cliente ?>&numero_container=<?= $numero_container ?>">
                <img src="../../assets/print.svg" alt="Imprimir" class="w-6 ml-4">
            </a> -->
        </div>
    </header>

    <!-- Adicionar Imagens por Fornecedor -->
    <section class="p-4 flex flex-col items-center justify-center text-center">
        <form id="formPreEmbarque" action="submit" class="flex flex-col space-y-4 w-full max-w-xl">
            <!-- Campos gerados dinamicamente -->


          
                <button
                id="buttonSave"
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 z-[2000] text-white w-[60px] h-[60px] rounded-full fixed bottom-[30px] right-[30px]">
                    <i class="fas fa-save w-[30px]"></i>

                </button>


        </form>

    </section>





    <footer class="text-center py-4 text-sm text-gray-500 dark:text-gray-400">
        <p id="data-footer"></p>
    </footer>

    <script src="../../onLoad/onLoad.js?v=1.7.1"></script>


    <script src="../../generalScripts/version.js?v=1.7.1"></script>
    <script src="../../generalScripts/backPage.js?v=1.7.1"></script>
    <script src="../js/preEmbarque.js?v=1.7.1"></script>




    <script>
        const uniqId = "<?= $id ?>"; // vindo do PHP via GET
        const dadosSalvos = <?= json_encode($dadosCampos, JSON_UNESCAPED_UNICODE) ?>;

        const camposPreEmbarque = [{
                nome: "Número do container",
                tipo: "foto"
            },
            {
                nome: "Número do lacre definitivo",
                tipo: "foto"
            },
            {
                nome: "Número do lacre provisório",
                tipo: "foto"
            },
            {
                nome: "Número do termógrafo",
                tipo: "foto"
            },
            {
                nome: "Verificar se o termógrafo está ligado corretamente",
                tipo: "video"
            },
            {
                nome: "Inserir as horas após ligar o termógrafo",
                tipo: "escrito"
            },
            {
                nome: "Placa do veículo",
                tipo: "foto"
            },
            {
                nome: "Hora de chegada do motorista",
                tipo: "escrito"
            },
            {
                nome: "Hora de saída do motorista",
                tipo: "escrito"
            },
            {
                nome: "Verificar se há avarias",
                tipo: "video"
            },
            {
                nome: "Verificar obstruções no dreno do container",
                tipo: "video"
            },
            {
                nome: "Número de nota fiscal de saída da empresa",
                tipo: "foto"
            },
            {
                nome: "Número de pedido",
                tipo: "foto"
            },
        ];

        const  buttonSave = document.getElementById('buttonSave')

        const form = document.getElementById("formPreEmbarque");

        camposPreEmbarque.forEach((campo, index) => {
            const nomeChave = `campo_${index}`;
            const campoSalvo = dadosSalvos[nomeChave];

            const wrapper = document.createElement("div");
            wrapper.className = "flex flex-col items-center gap-2 w-full p-4 rounded border border-gray-400 transition-colors";
            wrapper.dataset.card = nomeChave; // usado depois para resetar

            const label = document.createElement("label");
            label.textContent = campo.nome;
            label.className = "text-md font-semibold text-center";
            wrapper.appendChild(label);

            const nomeCampo = document.createElement("input");
            nomeCampo.type = "hidden";
            nomeCampo.name = `${nomeChave}_nome`;
            nomeCampo.value = campo.nome;
            wrapper.appendChild(nomeCampo);

            const preview = document.createElement("div");
            preview.className = "mt-2 w-full max-w-md";
            wrapper.appendChild(preview);

            if (campo.tipo === "escrito") {
                const input = document.createElement("input");
                input.name = nomeChave;
                input.type = "text";
                input.className = "w-full max-w-md p-2 border text-center rounded dark:bg-gray-800 dark:border-gray-600";
                if (campoSalvo?.resposta) {
                    input.value = campoSalvo.resposta;
                }
                wrapper.appendChild(input);

                input.addEventListener("input", () => {
                    const cardWrapper = input.closest("[data-card]");
                    if (cardWrapper) {
                        cardWrapper.classList.remove("border-gray-400");
                        cardWrapper.classList.add("border-orange-500");
                    }

                    buttonSave.classList.add('animate-bounce')
                
                    buttonSave.classList.remove('bg-green-600')
                    buttonSave.classList.add('bg-red-600')
                });

       

            } else {
                const inputGaleria = document.createElement("input");
                inputGaleria.name = nomeChave;
                inputGaleria.type = "file";
                inputGaleria.accept = campo.tipo === "foto" ? "image/*" : "video/*";
                inputGaleria.className = "file:bg-gray-300 file:rounded file:px-4 file:py-2 text-sm";
                wrapper.appendChild(inputGaleria);

                const inputCamera = document.createElement("input");
                inputCamera.name = nomeChave;
                inputCamera.type = "file";
                inputCamera.accept = campo.tipo === "foto" ? "image/*" : "video/*";
                inputCamera.capture = "environment";
                inputCamera.style.display = "none";
                inputCamera.id = `input_${index}_camera`;
                wrapper.appendChild(inputCamera);

                const botaoCamera = document.createElement("button");
                botaoCamera.type = "button";
                botaoCamera.className = campo.tipo === "foto" ?
                    "bg-blue-600 hover:bg-blue-700 w-full max-w-md text-white px-4 py-2 rounded" :
                    "bg-purple-600 hover:bg-purple-700 w-full max-w-md text-white px-4 py-2 rounded";
                botaoCamera.textContent = campo.tipo === "foto" ? "Tirar Foto" : "Gravar Vídeo";
                botaoCamera.onclick = () => document.getElementById(`input_${index}_camera`).click();
                wrapper.appendChild(botaoCamera);


                [inputGaleria, inputCamera].forEach((inputEl) => {
                    inputEl.addEventListener("change", function() {
                        const file = inputEl.files?.[0];
                        if (!file) return;

                        const previewElement = inputEl.closest("div.flex-col")?.querySelector("div.mt-2");
                        const cardWrapper = inputEl.closest("[data-card]");

                        if (!previewElement || !cardWrapper) return;

                        previewElement.innerHTML = "";

                        // Atualiza borda para laranja (não salvo)
                        cardWrapper.classList.remove("border-gray-400");
                        cardWrapper.classList.add("border-orange-500");

                            buttonSave.classList.add('animate-bounce')
                            buttonSave.classList.remove('bg-green-600')
                            buttonSave.classList.add('bg-red-600')

                        const url = URL.createObjectURL(file);

                        if (file.type.startsWith("image/")) {
                            const img = document.createElement("img");
                            img.src = url;
                            img.className = "w-full rounded border mt-2";
                            previewElement.appendChild(img);
                        } else if (file.type.startsWith("video/")) {
                            const video = document.createElement("video");
                            video.src = url;
                            video.controls = true;
                            video.className = "w-full rounded border mt-2";
                            previewElement.appendChild(video);
                        }
                    });
                });

                if (campoSalvo?.caminho) {
                    const ext = campoSalvo.caminho.split('.').pop().toLowerCase();
                    if (["jpg", "jpeg", "png"].includes(ext)) {
                        const img = document.createElement("img");
                        img.src = campoSalvo.caminho;
                        img.className = "w-full rounded border mt-2";
                        preview.appendChild(img);
                    } else if (["mp4", "webm"].includes(ext)) {
                        const video = document.createElement("video");
                        video.src = campoSalvo.caminho;
                        video.controls = true;
                        video.className = "w-full rounded border mt-2";
                        preview.appendChild(video);
                    }
                }
            }


            form.appendChild(wrapper);
        });


        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append("uniqId", uniqId);

            const inputs = form.querySelectorAll("input, textarea, select");

            for (let input of inputs) {
                const name = input.name;
                const type = input.type;
                const file = input.files?.[0];

                if (type === "file" && file) {
                    if (file.type.startsWith("image/")) {
                        const imagemRedimensionada = await redimensionarImagemComCanvas(file);
                        formData.append(name, imagemRedimensionada, `${uniqId}_${name}.jpg`);
                    } else if (file.type.startsWith("video/")) {
                        formData.append(name, file, `${uniqId}_${name}.mp4`);
                    }
                } else if (
                    type === "text" ||
                    input.tagName === "TEXTAREA" ||
                    input.tagName === "SELECT"
                ) {
                    formData.append(name, input.value);
                }

            }

            salvarDadosPreEmbarque(formData);
        });


        async function redimensionarImagemComCanvas(file, largura = 600, qualidade = 0.8) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        const canvas = document.createElement("canvas");

                        const aspectRatio = img.width / img.height;
                        canvas.width = largura;
                        canvas.height = largura / aspectRatio;

                        const ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        canvas.toBlob((blob) => {
                            resolve(blob);
                        }, "image/jpeg", qualidade);
                    };
                };
                reader.readAsDataURL(file);
            });
        }
    </script>

    <script>
        async function salvarDadosPreEmbarque(formData) {//salva os dados do pre embarque no banco de dados 
            mostrarLoader(); // mostra o loader

           
                    buttonSave.classList.remove('bg-red-600')
                    buttonSave.classList.add('bg-green-600')
                    buttonSave.classList.remove('animate-bounce')
                    buttonSave.classList.add('animate-pulse')
            
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            try {
                const response = await fetch("upload.php", {
                    method: "POST",
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error("Erro ao enviar dados.");
                }

                const data = await response.text();
                console.log(data)
                toastifyMessage('Pre-embarque salvo com sucesso!');
                document.querySelectorAll("[data-card]").forEach(card => {
                    card.classList.remove("border-orange-500");
                    card.classList.add("border-gray-400");
                });

                setTimeout(()=>{

                    window.location.reload()
                },500)

                // Atualize ou recarregue dados conforme necessário
            } catch (error) {
                console.error(error);
                toastifyMessage("Falha ao enviar os dados.", 'error');
            } finally {
                esconderLoader(); // esconde o loader

            }
        }


     
    </script>

    <script src="../../generalScripts/loader.js?v=1.7.1"></script>

    <script>
        document.getElementById("btnVoltar").addEventListener("click", async function(e) {
            const alterados = document.querySelectorAll("[data-card].border-orange-500");

            if (alterados.length > 0) {
                const confirmar = await appConfirm("Você tem alterações não salvas. Tem certeza que deseja sair?", { title: 'Sair sem salvar' });
                if (!confirmar) return;
            }

            // Redireciona
            window.location.href = "../preEmbarque.php";
        });
    </script>

    <script src="../../generalScripts/toastify.js?v=1.7.1"></script>


</body>


</html>
