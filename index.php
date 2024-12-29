    <?php  

    /**
     * @package     Joomla.Site
     * @subpackage  Cassiopeia Custom Template
     * @description Template for organizing technical documents with an integrated document viewer.
     */

    defined('_JEXEC') or die;

    $app = JFactory::getApplication();
    $templateParams = $app->getTemplate(true)->params;

    ?>
    <!DOCTYPE html>
    <html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
    <script src="https://apis.google.com/js/api.js"></script>
<script src="https://accounts.google.com/gsi/client"></script>
    
    <jdoc:include type="head" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
    /* Estilos generales */         
    body { 
    font-family: Arial, sans-serif; 
    display: flex; 
    margin: 0; 
    background-color: rgb(247, 247, 230); /* Beige pastel */
    color: rgb(40, 40, 40); /* Negro suave */
}

#gSignInWrapper {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 9999; /* Asegura que el botón esté por encima de otros elementos */
}

    #google-signin-button {
    margin-top: 5px;
    }

    .container { max-width: 1200px; margin-left: 220px; padding: 20px; display: flex; flex-direction: column; }
    #sidebar { 
        width: 200px; 
        position: fixed; 
        top: 0; 
        left: 0; 
        background-color: #f4f4f4; 
        padding: 10px; 
        border-right: 2px solid #ccc; 
        height: 100vh;
    }
    #sidebar ul {
        list-style: none;
        padding: 0;
    }
    #sidebar li {
        margin-bottom: 15px;
    }
    #sidebar a {
        color: #0056b3;
        text-decoration: none;
        font-weight: bold;
    }
    #sidebar a:hover {
        color: #003366;
    }
    .category-block { 
        border: 1px solid #ccc; 
        padding: 15px; 
        margin-bottom: 25px; 
        border-radius: 5px; 
        background-color: #f9f9f9;
    }
    .category-block h3 { 
        cursor: pointer; 
        margin: 0; 
        font-size: 1.2em; 
        color: #0056b3;
    }
    .category-block h3:hover {
        color: #003366;
    }
    .subcategory-list { 
        display: none; 
        margin: 10px 0; 
        padding: 0; 
        list-style: none; 
    }
    .subcategory-list li { 
        margin-bottom: 5px; 
        cursor: pointer; 
        padding: 8px; 
        background-color: #e0e0e0;
        border-radius: 3px;
    }
    .subcategory-list li:hover { background-color: #d1d1d1; }

    /* Estilos para el visualizador de documentos */
    .viewer {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        width: 50%;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        display: none;
        box-sizing: border-box;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    #loading-indicator {
        display: none;
        position: absolute;
        top: 50%;
        left: 73%;
        transform: translate(-50%, -50%);
        text-align: center;
        font-size: 18px;
    }

    iframe {
        width: 100%;
        height: 500px;
        border: none;
    }

    /* Indicador de carga */
    #loading-indicator {
        display: none;
        text-align: center;
        padding: 20px;
        font-size: 18px;
    }

    .section {
        display: none;
    }

    .active {
        display: block;
    }

    /* Estilos para la línea negra debajo de la categoría de Procedimiento de Limpieza */
    .divider {
        border-bottom: 2px solid black;
        margin: 20px 0;
    }

    /* Estilo para el estado de cada solicitud */
    .status-section {
        border: 1px solid #ccc;
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .status-section h3 {
        cursor: pointer;
    }

    /* Estilos para los enlaces habilitados y deshabilitados */
    .link-disabled {
        color: #ccc;
        text-decoration: line-through;
        pointer-events: none;  /* No permite hacer clic en el enlace */
    }

    .link-enabled {
        color: #0056b3;
        text-decoration: underline;
    }

    .link-enabled:hover {
        color: #003366;
    }

    /* Estado aprobado y apagado */
    .status.aprobado {
        color: blue;  /* Color azul para "Aprobado" */
    }

    .status.apagado {
    color: #ccc;  /* Color gris o apagado */
    }

    /* Estilos para el botón "Elementos Aprobados" */
    #approved-items-button {
    position: fixed;
    top: 10px;
    left: 10px;
    background-color: #0056b3;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 14px;
}

    #approved-items-button:hover {
    background-color: #003366;
}

    h2 { 
    background-color: rgb(243, 232, 175); /* Verde brillante */
    color: rgb(40, 40, 40); /* Negro suave para contraste */
    text-align: center;
    padding: 22px 0;
    margin: 0 0 10px 0;
    font-size: 2em;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    width: 120%; /* Ajusta el ancho a un 80% del contenedor */
    margin-left: auto; /* Centra el elemento */
    margin-right: auto; /* Centra el elemento */
}

    .formulario {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

    .imagen {
    position: absolute;
    top: 45%;
    left: 70%;
    transform: translate(-50%, -50%);
    max-width: 100%;
    max-height: 700px; /* Ajustar altura máxima de la imagen */
    object-fit: contain; /* Asegura que la imagen mantenga sus proporciones */
    border-radius: 10px; /* Bordes redondeados */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra */
}

        </style>
    </head>
    <body>
    <aside id="sidebar">
        <ul>
            <li><a href="javascript:void(0);" onclick="showSection('documents')">Documentos</a></li>
            <li><a href="javascript:void(0);" onclick="showSection('upload')">Subir Documentos</a></li>
            <li><a href="javascript:void(0);" onclick="showSection('status')">Consultar Estado</a></li>
        </ul>
    </aside>
    <main class="container">
        <h2>Gestor de Documentos</h2>
        
        <section id="documents" class="section active">
            <h3>Documentos</h3>
            <div id="category-blocks">
                <?php
                // Categorías y subcategorías con enlaces
                $categories = [
                    'Manual de Operación' => [
                        'Introducción' => ['url' => 'https://drive.google.com/embeddedfolderview?id=19PRVnwyyogLO9ui73fSjmLLyO11ryrhK#grid'],
                        'Operación Básica' => ['url' => 'https://drive.google.com/embeddedfolderview?id=17WT_SJ5GGtek53gNwzdDmfVY8rWsXwnn#grid'],
                        'Avanzada' => ['url' => 'https://drive.google.com/embeddedfolderview?id=1tqy2xYj1XfEVEHNQBJAzEs-Go87pl-Nt#grid']
                    ],
                    'Especificaciones Técnicas' => [
                        'Materiales' => ['url' => 'https://drive.google.com/embeddedfolderview?id=1zGLScN5h_CldrvQk-KmxWyIAuriLs21o#grid'],
                        'Procesos' => ['url' => 'https://drive.google.com/embeddedfolderview?id=1CRkmYzsH2Vpbq4OzoOV-3ly8hpX3MlHW#grid']
                    ],
                    'Procedimientos de Limpieza' => [
                        'Productos Recomendados' => ['url' => 'https://drive.google.com/embeddedfolderview?id=1SPmkDq6w2M-HZ5y-lmsV3s_yg1NAdhUi#grid'],
                        'Técnicas' => ['url' => 'https://drive.google.com/embeddedfolderview?id=1JyfrkPJLjtc_t9ttIbVp8GUkKpnrSs23#grid']
                    ]
                ];

                foreach ($categories as $category => $subcategories) {
                    echo '<div class="category-block" id="category-' . strtolower(str_replace(' ', '-', $category)) . '">';
                    echo '<h3 onclick="toggleSubcategories(this)">' . $category . '</h3>';
                    echo '<ul class="subcategory-list">';
                    foreach ($subcategories as $subcategory => $details) {
                        echo '<li onclick="loadDocumentViewer(\'' . $details['url'] . '\')">' . $subcategory . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="divider"></div> <!-- Línea negra debajo de "Procedimiento de Limpieza" -->
            <!-- Nuevas secciones cargadas dinámicamente se colocarán aquí -->
            <div id="dynamic-sections">
                <!-- Las nuevas secciones con estados se agregarán aquí -->
            </div>
            <!-- Indicador de carga -->
            <div id="loading-indicator">
                <span>Cargando...</span>
            </div>
            <!-- Contenedor para el visor de documentos con la clase 'viewer' -->
            <div class="viewer">
                <iframe id="document-viewer" src="" title="Visualizador de Documentos"></iframe>
            </div>
        </section>
        <section id="upload" class="section">
            <h3>Subir Documentos</h3>
            <button class= "formulario" onclick="window.open('https://docs.google.com/forms/d/e/1FAIpQLSdnRklJyVap6guq1R-N4b4W9AIZODhTz_VG8O9HR3nG8TdVnw/viewform', 'popup', 'width=800,height=600');">
                Dar Clic para Cargar Archivo de manera en Línea
            </button>
<div class="imagen">
        <img src="https://www.agetic.gob.bo/wp-content/uploads/2023/10/1632-disenando-un-gestor-documental-que-se-adapte-por-completo-a-las-necesidades-de-las-empresas-encargadas-de-la-conservacion-y-explotacion-de-carreteras.jpg" alt="Imagen representativa">
    </div>
        </section>
        <section id="status" class="section">
            <h3>Estado de Documentos</h3>
            <!-- Formulario para agregar enlaces manualmente -->
            <div id="add-link-form">
                <label for="link-url">Ingrese el enlace de Google Drive:</label>
                <input type="text" id="link-url" placeholder="https://drive.google.com/..." />
                <button onclick="addLink(),generatePreviewLink()" >Aceptar</button>
             </div>
            <!-- Sección para mostrar los enlaces agregados -->
            <div id="link-history">
                <h4>Historial de Enlaces</h4>
                <ul id="history-list">
                    <!-- Los enlaces se agregarán aquí dinámicamente -->
                </ul>
                <div class="imagen">
        <img src="https://www.agetic.gob.bo/wp-content/uploads/2023/10/1632-disenando-un-gestor-documental-que-se-adapte-por-completo-a-las-necesidades-de-las-empresas-encargadas-de-la-conservacion-y-explotacion-de-carreteras.jpg" alt="Imagen representativa">
    </div>
            </div>
        </section>
        <div id="gSignInWrapper">    
    <div id="google-signin-button"></div>
</div>

    </main>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>
        let linkOrder = [];
        let linkStates = {};  // Objeto para mantener los estados de los enlaces
        let linkUrls = {};  // Objeto para almacenar las URLs de los enlaces
        let linkCounter = 0;  // Contador para generar un ID único

        
        function renderButton() {
        gapi.signin2.render('google-signin-button', {
            'scope': 'profile email',
            'longtitle': true,
            'theme': 'dark',
            'onsuccess': handleCredentialResponse,
            'onfailure': handleCredentialResponse
        });
    }

        function toggleSubcategories(element) {
            const subcategoryList = element.nextElementSibling;
            if (subcategoryList.style.display === 'none' || subcategoryList.style.display === '') {
                subcategoryList.style.display = 'block';
            } else {
                subcategoryList.style.display = 'none';
            }
        }
        
        function showApprovedItems() {
        const approvedLinks = Array.from(document.querySelectorAll('.link-enabled'));
        console.log('Elementos aprobados encontrados:', approvedLinks);
        
        if (approvedLinks.length > 0) {
            const firstApprovedUrl = approvedLinks[0].getAttribute('data-url');
            console.log('URL del primer elemento aprobado:', firstApprovedUrl);
            
            const iframe = document.getElementById('document-viewer');
            const viewer = document.querySelector('.viewer');
            
            iframe.src = firstApprovedUrl;
            viewer.style.display = 'block';
            viewer.style.opacity = '1';
        } else {
            alert('No hay elementos aprobados para mostrar.');
        }
    }

        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }


    function addLink() {
    const linkUrl = document.getElementById('link-url').value;
    if (linkUrl) {
        // Extraer el ID del enlace de Google Drive
        const idMatch = linkUrl.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (!idMatch || !idMatch[1]) {
            alert('Por favor, ingrese un enlace válido de Google Drive.');
            return;
        }

        const driveId = idMatch[1];
        const previewLink = `https://drive.google.com/file/d/${driveId}/preview`;

        // Verifica si el enlace ya está en el historial
        if (linkOrder.includes(previewLink)) {
            alert('Este enlace ya está en el historial.');
            return;
        }

        // Generar un ID único para este enlace
        const uniqueId = 'link-' + linkCounter++;

        // Asigna el estado "Pendiente" por defecto
        const initialState = 'Pendiente';

        // Agregar el enlace al historial
        const historyList = document.getElementById('history-list');
        const newLink = document.createElement('li');
        newLink.innerHTML = ` 
            <span>ID: ${uniqueId}</span>
            <a href="javascript:void(0);" onclick="loadDocumentViewer('${previewLink}')" id="${uniqueId}-link" class="link-disabled">Ver Documento</a>
            <select onchange="updateState(this, '${uniqueId}', '${previewLink}')">
                <option value="Seleccionar">Seleccionar</option>
                <option value="Pendiente">Pendiente</option>
                <option value="En revisión">En revisión</option>
                <option value="Aprobado">Aprobado</option>
            </select>
        `;
        historyList.appendChild(newLink);

        linkOrder.push(previewLink); // Mantener el orden de los enlaces
        linkUrls[previewLink] = uniqueId; // Guardar el ID único asociado con la URL

        linkStates[previewLink] = initialState; // Por defecto, los enlaces estarán en "Pendiente"
        document.getElementById('link-url').value = ''; // Limpiar campo de entrada

        // Si el estado es "Aprobado", activamos el enlace
        if (initialState === 'Aprobado') {
            const linkElement = document.getElementById(`${uniqueId}-link`);
            linkElement.classList.remove('link-disabled');
            linkElement.classList.add('link-enabled');
            linkElement.href = previewLink; // Asigna la URL activa
            linkElement.textContent = 'Ver Documento'; // Texto claro para los usuarios
        }
    }
}

    function updateState(selectElement, uniqueId, linkUrl) {
        const selectedState = selectElement.value;
        linkStates[linkUrl] = selectedState; // Actualiza el estado del enlace en el objeto

        const linkElement = document.getElementById(`${uniqueId}-link`);
        if (linkElement) {
            if (selectedState === 'Aprobado') {
                // Hacer visible el enlace "Ver Documento"
                linkElement.classList.remove('link-disabled');
                linkElement.classList.add('link-enabled');
                linkElement.href = linkUrl; // Asigna la URL activa
                linkElement.textContent = 'Ver Documento'; // Texto claro para los usuarios
            } else {
                // Si no está aprobado, deshabilitar el enlace
                linkElement.classList.remove('link-enabled');
                linkElement.classList.add('link-disabled');
                linkElement.href = ''; // Limpia la URL
                linkElement.textContent = 'Estado no aprobado'; // Muestra texto para indicar estado
            }
        }
        // También actualizamos el estado en la vista de "Documentos" de acuerdo con el estado del enlace
        updateDocumentState(linkUrl, selectedState, uniqueId);
    }

    function updateDocumentState(linkUrl, state, uniqueId) {
        // Actualizar el estado del documento en la sección de "Documentos"
        const categoryBlocks = document.querySelectorAll('.category-block');
        
        categoryBlocks.forEach(block => {
            const subcategoryList = block.querySelectorAll('.subcategory-list li');
            
            subcategoryList.forEach(subcategory => {
                if (subcategory.dataset.url === linkUrl) {
                    const linkElement = subcategory.querySelector('a');
                    if (state === 'Aprobado') {
                        // Crear un nuevo enlace si es aprobado
                        const newLink = document.createElement('a');
                        newLink.href = linkUrl;
                        newLink.classList.add('link-enabled');
                        newLink.textContent = 'Ver Documento';
                        subcategory.innerHTML = ''; // Limpiar la subcategoría
                        subcategory.appendChild(newLink); // Insertar el nuevo enlace
                    } else {
                        if (linkElement) {
                            linkElement.classList.remove('link-enabled');
                            linkElement.classList.add('link-disabled');
                            linkElement.href = '';  // Deshabilitar el enlace
                            subcategory.textContent = state; // Mostrar el estado como texto
                        }
                    }
                }
            });
        });

        // Actualización sincronizada en el área de las secciones dinámicas
        const dynamicSections = document.getElementById('dynamic-sections');
        const existingSection = document.getElementById(uniqueId);

        if (existingSection) {
            const statusSpan = existingSection.querySelector('.status');
            const linkElement = existingSection.querySelector('.link-enabled');
            
            statusSpan.innerText = `Estado: ${state}`;
            // Aplicar la clase basada en el estado para el estado
                if (state === 'Aprobado') {
                statusSpan.classList.add('aprobado');
                statusSpan.classList.remove('apagado');
                
                // Hacer que el enlace sea habilitado
                if (linkElement) {
                    linkElement.classList.add('link-enabled');
                    linkElement.classList.remove('link-disabled');
                    linkElement.href = linkUrl; // Restaurar el enlace
                }
            } else {
                statusSpan.classList.add('apagado');
                statusSpan.classList.remove('aprobado');
                
                // Hacer que el enlace sea deshabilitado
                if (linkElement) {
                    linkElement.classList.add('link-disabled');
                    linkElement.classList.remove('link-enabled');
                    linkElement.href = ''; // Deshabilitar el enlace
                }
            }
        } else {
            // Crear una nueva sección para el enlace con el estado
            const newSection = document.createElement('div');
            newSection.id = uniqueId;
            newSection.classList.add('status-section');

            // Aquí agregamos el enlace para redirigir al URL propuesto
            const statusClass = (state === 'Aprobado') ? 'aprobado' : 'apagado';
            const linkClass = (state === 'Aprobado') ? 'link-enabled' : 'link-disabled';
            const linkHref = (state === 'Aprobado') ? linkUrl : '';  // Si está aprobado, permitir el enlace

            newSection.innerHTML = `
        <h3>ID: ${uniqueId} <span class="status ${statusClass}">Estado: ${state}</span></h3>
        <p class="status">
            <a href="javascript:void(0);" onclick="loadDocumentViewer('${linkUrl}')" class="${linkClass}" id="${uniqueId}-link">Ver Documento</a>
        </p>
    `;

            dynamicSections.appendChild(newSection);
        }
    }

    function loadDocumentViewer(url) {
            const viewerContainer = document.querySelector('.viewer');
            const iframe = document.getElementById('document-viewer');
            const loadingIndicator = document.getElementById('loading-indicator');
            
            iframe.src = url;

            // Mostrar el visor y el indicador de carga
            viewerContainer.style.display = 'block';  // Muestra el contenedor del visor
            viewerContainer.style.opacity = '0';      // Comienza invisible
            loadingIndicator.style.display = 'block'; // Muestra el indicador de carga

            // Cuando el iframe termine de cargar, muestra el contenido y oculta el indicador de carga
            iframe.onload = function() {
                loadingIndicator.style.display = 'none';  // Oculta el indicador de carga
                viewerContainer.style.opacity = '1';      // Muestra el iframe con una transición suave
            };
        }

    window.onload = function () {
    google.accounts.id.initialize({
        client_id: "862539758703-ndjikdmsln8vcbunc7ihigck26057b0v.apps.googleusercontent.com",
        callback: handleCredentialResponse,
        itp_support: true
    });

    function start() {
        gapi.load('auth2', function() {
            gapi.auth2.init({
                client_id: '862539758703-ndjikdmsln8vcbunc7ihigck26057b0v.apps.googleusercontent.com'
            });
        });
    }

    google.accounts.id.renderButton(
        document.getElementById("google-signin-button"),
        { theme: "outline", size: "large" } // Opciones de diseño del botón
    );

    google.accounts.id.prompt(); // Opcional, para mostrar el cuadro de inicio de sesión automático
};

    function handleCredentialResponse(response) {
        console.log("Credenciales recibidas:", response);
    const user = gapi.auth2.getAuthInstance().currentUser.get();
    const id_token = user.getAuthResponse().id_token;
    
    // Enviar el token al backend para validarlo
    fetch('google_drive.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_token=${id_token}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Respuesta del servidor: ", data);
        // Aquí puedes manejar la respuesta del servidor, como redirigir al usuario o mostrar un mensaje
    })
    .catch(error => console.error('Error al enviar el token al servidor:', error));

     // Al cargar la página, inicializamos y renderizamos el botón de Google
    window.onload = function () {
        // Inicializamos el cliente de Google para la autenticación
        start();
        
        // Llamamos a la función para renderizar el botón
        renderButton();
    };
}

    function generatePreviewLink() {
            const input = document.getElementById('driveLink').value;
            const idMatch = input.match(/\/d\/([a-zA-Z0-9_-]+)/);

            if (idMatch && idMatch[1]) {
                const extractedID = idMatch[1];
                const previewLink = `https://drive.google.com/file/d/${extractedID}/preview`;
                document.getElementById('result').textContent = `Enlace de vista previa: ${previewLink}`;
            } else {
                document.getElementById('result').textContent = 'No se encontró un ID válido en el enlace.';
            }
        }
    </script>
    </body>
    </html>
