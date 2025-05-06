<x-kaira-layout>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos | Nome do Site</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --light-color: #ecf0f1;
            --dark-color: #a5abb1;
            --success-color: #2ecc71;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #aca3a3;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--dark-color);
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(172, 167, 167, 0.747);
        }
        
        header h1 {
            margin-bottom: 10px;
        }
        
        .contact-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
        }
        
        .contact-info {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .contact-info h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .info-item i {
            font-size: 20px;
            color: var(--primary-color);
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        
        .contact-form {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .contact-form h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: var(--secondary-color);
        }
        
        .success-message {
            background-color: var(--success-color);
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: none;
        }
        
       
        
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Contacte-nos</h1>
            <p>Estamos aqui para ajudar e responder a todas as suas questões.</p>
        </div>
    </header>
    
    <div class="container">
        <?php
        // Processar o formulário quando for submetido
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = htmlspecialchars($_POST['nome']);
            $email = htmlspecialchars($_POST['email']);
            $assunto = htmlspecialchars($_POST['assunto']);
            $mensagem = htmlspecialchars($_POST['mensagem']);
            
            // Validação básica
            $errors = [];
            
            if (empty($nome)) {
                $errors[] = "O nome é obrigatório.";
            }
            
            if (empty($email)) {
                $errors[] = "O email é obrigatório.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "O email não é válido.";
            }
            
            if (empty($mensagem)) {
                $errors[] = "A mensagem é obrigatória.";
            }
            
            // Se não houver erros, processar o formulário
            if (empty($errors)) {
                // Aqui você normalmente enviaria um email ou guardaria na base de dados
                // Para este exemplo, apenas mostraremos uma mensagem de sucesso
                $success = true;
            }
        }
        ?>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message" style="color: red; margin-bottom: 20px;">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success) && $success): ?>
            <div class="success-message" id="successMessage" style="display: block;">
                Obrigado pela tua mensagem! Entraremos em contacto brevemente.
            </div>
            
            <script>
                // Esconder a mensagem de sucesso após 5 segundos
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                }, 5000);
            </script>
        <?php endif; ?>
        
        <div class="contact-container">
            <div class="contact-info">
                <h2>Informações de Contacto</h2>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Morada</h3>
                        <p>Rua Exemplo, 123<br>1000-001 Lisboa, Portugal</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <h3>Telefone</h3>
                        <p>+351 123 456 789</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p>geral@exemplo.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Horário</h3>
                        <p>Segunda - Sexta: 9:00 - 18:00<br>Sábado: 10:00 - 14:00</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-share-alt"></i>
                    <div>
                        <h3>Redes Sociais</h3>
                        <div style="font-size: 24px; margin-top: 10px;">
                            <a href="#" style="color: var(--primary-color); margin-right: 15px;"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="color: var(--primary-color); margin-right: 15px;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: var(--primary-color); margin-right: 15px;"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="color: var(--primary-color);"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h2>Envie-nos uma Mensagem</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" required value="<?php echo isset($nome) ? $nome : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="assunto">Assunto</label>
                        <input type="text" id="assunto" name="assunto" value="<?php echo isset($assunto) ? $assunto : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" required><?php echo isset($mensagem) ? $mensagem : ''; ?></textarea>
                    </div>
                    
                    <button type="submit">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
</x-kaira-layout>