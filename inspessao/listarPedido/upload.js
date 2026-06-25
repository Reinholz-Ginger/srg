function canvasParaBlob(canvas, quality) {
    return new Promise((resolve, reject) => {
        canvas.toBlob((blob) => {
            if (!blob) {
                reject(new Error('Não foi possível gerar a imagem redimensionada.'));
                return;
            }

            resolve(blob);
        }, 'image/jpeg', quality);
    });
}

function carregarImagem(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = () => reject(new Error('Não foi possível carregar a imagem selecionada.'));
            img.src = event.target.result;
        };

        reader.onerror = () => reject(new Error('Não foi possível ler o arquivo selecionado.'));
        reader.readAsDataURL(file);
    });
}

function redimensionarImagem(img, maxWidth, quality) {
    const canvas = document.createElement('canvas');
    const aspectRatio = img.width / img.height;

    canvas.width = maxWidth;
    canvas.height = maxWidth / aspectRatio;

    const context = canvas.getContext('2d');
    context.drawImage(img, 0, 0, canvas.width, canvas.height);

    return canvasParaBlob(canvas, quality);
}

async function lerRespostaUpload(response) {
    const rawText = await response.text();

    try {
        const data = rawText ? JSON.parse(rawText) : {};
        return { data, rawText };
    } catch (error) {
        return {
            data: {
                success: false,
                message: 'Resposta inválida do servidor.',
                error: rawText
            },
            rawText
        };
    }
}

function adicionarImagemNaTela(inputElement, data) {
    const uploadSlot = inputElement.closest('.inputThumbnail');
    const container = uploadSlot?.closest('.inputContainer');

    if (!container || !uploadSlot || !data.id_imagem || !data.thumbnail) {
        console.warn('Não foi possível atualizar a imagem na tela:', { data, inputElement });
        return;
    }

    const idImagem = data.id_imagem;
    const cardExistente = document.getElementById(`${idImagem}thumb`);

    if (cardExistente) {
        cardExistente.remove();
    }

    const card = document.createElement('div');
    card.id = `${idImagem}thumb`;
    card.className = 'thumbnailImageLoaded';

    const apagarButton = document.createElement('button');
    apagarButton.type = 'button';
    apagarButton.className = 'apagarImagem';
    apagarButton.title = 'Apagar imagem';
    apagarButton.addEventListener('click', () => apagarImagem(idImagem));

    const apagarIcone = document.createElement('img');
    apagarIcone.src = '../../assets/erase1.svg';
    apagarIcone.alt = 'Apagar';
    apagarButton.appendChild(apagarIcone);

    const imagemWrapper = document.createElement('div');
    imagemWrapper.className = 'buttonUploadImg';

    const imagem = document.createElement('img');
    imagem.src = data.thumbnail;
    imagem.alt = 'Imagem da inspeção';
    imagemWrapper.appendChild(imagem);

    const inputThumb = document.createElement('input');
    inputThumb.type = 'hidden';
    inputThumb.id = `${idImagem}inputThumb`;
    inputThumb.value = data.thumbnail;

    const inputHigh = document.createElement('input');
    inputHigh.type = 'hidden';
    inputHigh.id = `${idImagem}input`;
    inputHigh.value = data.high_definition || '';

    card.appendChild(apagarButton);
    card.appendChild(imagemWrapper);
    card.appendChild(inputThumb);
    card.appendChild(inputHigh);

    container.insertBefore(card, uploadSlot);
}

async function enviarImagem(inputElement) {
    const divSalvando = document.getElementById('loadingScreen');
    divSalvando.classList.remove('hidden');
    const finalizarLoading = () => {
        divSalvando.classList.add('hidden');
        inputElement.value = '';
    };

    try {
        const id_item = inputElement.getAttribute('id');
        const file = inputElement.files[0];

        if (!file) {
            console.log('Nenhuma imagem selecionada.');
            return;
        }

        const img = await carregarImagem(file);
        const blobThumb = await redimensionarImagem(img, 300, 0.2);
        const blobHigh = await redimensionarImagem(img, 600, 0.8);

        const formData = new FormData();
        formData.append('id_item', id_item);
        formData.append('imagem1', blobThumb, 'redimensionada_thumb.jpg');
        formData.append('imagem2', blobHigh, 'redimensionada_hd.jpg');

        const response = await fetch('upload.php', {
            method: 'POST',
            body: formData
        });

        const { data, rawText } = await lerRespostaUpload(response);

        if (!response.ok || !data.success) {
            console.error('Erro ao enviar imagem da inspeção:', {
                status: response.status,
                statusText: response.statusText,
                resposta: data,
                corpoOriginal: rawText
            });

            finalizarLoading();
            await appAlert(data.message || 'Erro ao enviar imagem. Verifique o console do sistema.', { title: 'Upload da inspeção' });
            return;
        }

        console.log('Imagem da inspeção salva:', data);
        finalizarLoading();
        adicionarImagemNaTela(inputElement, data);
    } catch (error) {
        console.error('Erro inesperado ao enviar imagem da inspeção:', error);
        finalizarLoading();
        await appAlert('Erro ao enviar imagem. Verifique o console do sistema.', { title: 'Upload da inspeção' });
    } finally {
        finalizarLoading();
    }
}
