//alterar a versão do sistema

const versao = '1.7.2';
const element = document.getElementById('data-footer');
const data = () => {
    if (!element) return;

    const gerarData = new Date();
    const dataFormatada = gerarData.toLocaleString(undefined, { year: 'numeric', minimumIntegerDigits: 4 });
    element.textContent = `V ${versao} |  ${dataFormatada}  © Lucas Roncheti CodeDesigner `;
};

data();

(function () {
    const modalId = 'app-feedback-modal';
    const styleId = 'app-feedback-modal-style';

    function ensureModalStyle() {
        if (document.getElementById(styleId)) {
            return;
        }

        const style = document.createElement('style');
        style.id = styleId;
        style.textContent = `
            .app-modal-overlay{position:fixed;inset:0;z-index:999999999;display:none;align-items:center;justify-content:center;background:rgba(0,0,0,.45);padding:16px}
            .app-modal-overlay.is-open{display:flex}
            .app-modal-box{width:100%;max-width:380px;border-radius:8px;background:#fff;color:#111827;box-shadow:0 24px 48px rgba(15,23,42,.24);overflow:hidden}
            .app-modal-header{border-bottom:1px solid #e5e7eb;padding:16px 20px}
            .app-modal-title{margin:0;font-size:16px;font-weight:700;letter-spacing:0}
            .app-modal-body{padding:16px 20px}
            .app-modal-message{margin:0;color:#374151;font-size:14px;line-height:1.6;white-space:pre-wrap}
            .app-modal-actions{display:flex;justify-content:flex-end;gap:8px;border-top:1px solid #e5e7eb;padding:12px 20px}
            .app-modal-button{min-height:38px;border-radius:6px;border:1px solid transparent;padding:0 16px;font-size:14px;font-weight:700;cursor:pointer}
            .app-modal-button-primary{background:#16a34a;color:#fff}
            .app-modal-button-primary:hover{background:#15803d}
            .app-modal-button-secondary{border-color:#d1d5db;background:#fff;color:#374151}
            .app-modal-button-secondary:hover{background:#f3f4f6}
            .app-modal-hidden{display:none}
            .dark .app-modal-box{background:#1f2937;color:#f9fafb}
            .dark .app-modal-header,.dark .app-modal-actions{border-color:#374151}
            .dark .app-modal-message{color:#e5e7eb}
            .dark .app-modal-button-secondary{border-color:#4b5563;background:#1f2937;color:#e5e7eb}
            .dark .app-modal-button-secondary:hover{background:#374151}
        `;
        document.head.appendChild(style);
    }

    function ensureModal() {
        let modal = document.getElementById(modalId);

        if (modal) {
            return modal;
        }

        ensureModalStyle();
        modal = document.createElement('div');
        modal.id = modalId;
        modal.className = 'app-modal-overlay';
        modal.innerHTML = `
            <div class="app-modal-box">
                <div class="app-modal-header">
                    <h2 data-app-modal-title class="app-modal-title">Mensagem</h2>
                </div>
                <div class="app-modal-body">
                    <p data-app-modal-message class="app-modal-message"></p>
                </div>
                <div class="app-modal-actions">
                    <button type="button" data-app-modal-cancel class="app-modal-button app-modal-button-secondary app-modal-hidden">Cancelar</button>
                    <button type="button" data-app-modal-ok class="app-modal-button app-modal-button-primary">OK</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        return modal;
    }

    function openModal({ title = 'Mensagem', message = '', confirm = false, okText = 'OK', cancelText = 'Cancelar' }) {
        if (!document.body) {
            return Promise.resolve(!confirm);
        }

        const modal = ensureModal();
        const titleEl = modal.querySelector('[data-app-modal-title]');
        const messageEl = modal.querySelector('[data-app-modal-message]');
        const okButton = modal.querySelector('[data-app-modal-ok]');
        const cancelButton = modal.querySelector('[data-app-modal-cancel]');

        titleEl.textContent = title;
        messageEl.textContent = message;
        okButton.textContent = okText;
        cancelButton.textContent = cancelText;
        cancelButton.classList.toggle('app-modal-hidden', !confirm);
        modal.classList.add('is-open');
        okButton.focus();

        return new Promise((resolve) => {
            const cleanup = (result) => {
                modal.classList.remove('is-open');
                okButton.removeEventListener('click', onOk);
                cancelButton.removeEventListener('click', onCancel);
                modal.removeEventListener('click', onBackdrop);
                document.removeEventListener('keydown', onKeydown);
                resolve(result);
            };

            const onOk = () => cleanup(true);
            const onCancel = () => cleanup(false);
            const onBackdrop = (event) => {
                if (event.target === modal) cleanup(!confirm);
            };
            const onKeydown = (event) => {
                if (event.key === 'Escape') cleanup(!confirm);
            };

            okButton.addEventListener('click', onOk);
            cancelButton.addEventListener('click', onCancel);
            modal.addEventListener('click', onBackdrop);
            document.addEventListener('keydown', onKeydown);
        });
    }

    window.appAlert = function (message, options = {}) {
        return openModal({
            title: options.title || 'Aviso',
            message: String(message ?? ''),
            okText: options.okText || 'Entendi'
        });
    };

    window.appConfirm = function (message, options = {}) {
        return openModal({
            title: options.title || 'Confirmação',
            message: String(message ?? ''),
            confirm: true,
            okText: options.okText || 'Confirmar',
            cancelText: options.cancelText || 'Cancelar'
        });
    };
})();



   //  // função para validar o tamanho da tela 
   //  validador = 0

    
   //  window.addEventListener("resize", function() {

   //      let body = document.body
   //      // O código aqui será executado sempre que a janela for redimensionada.
   //      const bodyWidth = document.body.clientWidth;
   //      const bodyHeight = document.body.clientHeight;

   //      if(bodyWidth >= 768 ){
   //         body.innerHTML = "<div class='mensagem'><p> Este sistema não é otimizado para desktop<p><BR><p> Acesse por um smartphone ou tablet <p></div> "
           
           
   //         validador = 1
   //      }
   //      if(bodyWidth <= 768 && validador == 1 ){
   //         window.location.reload()
   //         validador = 0
           
   //      }
      
       
   //    });

   //    let verificarTamanhoTela = ()=>{

   //      let body = document.body
   //      // O código aqui será executado sempre que a janela for redimensionada.
   //      const bodyWidth = document.body.clientWidth;
   //      const bodyHeight = document.body.clientHeight;

   //      if(bodyWidth >= 768 ){
   //         body.innerHTML = "<div class='mensagem'><p> Este sistema não é otimizado para desktop<p><BR><p> Acesse por um smartphone  ou tablet<p></div> "
           
           
   //         validador = 1
   //      }
   //      if(bodyWidth <= 768 && validador == 1 ){
   //         window.location.reload()
   //         validador = 0
           
   //      }
      

   //    }


