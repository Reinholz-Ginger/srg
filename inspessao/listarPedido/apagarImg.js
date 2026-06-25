
async function apagarImagem(id) {
    const preload = document.getElementById('preload');
    preload.style.display = 'block';
    const id_img = id; // id da imagem que foi clicada 
    const idD = id;
    const idToDelete = idD + "thumb"; // id para deletar a div 
    const pathHd = idD + "input" // id com o path em alta definição para ser apagado  
    const path = idD + "inputThumb" // id com o path em thumbnail  para ser apagado  

    const thumnailPath = document.getElementById(path)?.value || '';
    const imagemAltaPath = document.getElementById(pathHd)?.value || '';
    const element = document.getElementById(idToDelete);

    const formData = new FormData();

    formData.append('id_image', id_img);
    formData.append('path', thumnailPath);
    formData.append('pathHD', imagemAltaPath);

    try {
        const response = await fetch('apagarImg.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        if (data.success) {
            if (element) {
                element.parentNode.removeChild(element);
            }
            return;
        }

        console.error('Erro ao apagar imagem da inspeção:', {
            status: response.status,
            resposta: data
        });
        await appAlert(data.message || 'Não foi possível apagar a imagem.', { title: 'Imagem da inspeção' });
    } catch (error) {
        console.error('Erro inesperado ao apagar imagem da inspeção:', error);
        await appAlert('Não foi possível apagar a imagem. Verifique o console do sistema.', { title: 'Imagem da inspeção' });
    } finally {
        preload.style.display = 'none';
    }
}
