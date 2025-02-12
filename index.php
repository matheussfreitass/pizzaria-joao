<?php include_once("templates/header.php"); ?>
<?php include_once("process/pizza.php"); ?>

<div id="main-banner">
    <h1>Faça seu pedido</h1>
</div>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Monte a sua pizza</h2>
                <form action="process/pizza.php" method="post" id="pizza-form">
                    
                    <!-- Borda -->
                    <div class="form-group">
                        <label for="borda">Borda: </label>
                        <select name="borda" id="borda" class="form-control">
                            <option value="">Selecione a borda</option>
                            <?php foreach ($bordas as $borda): ?>
                                <option value="<?= $borda['id'] ?>"><?= $borda["tipo"] ?></option>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <!-- Massa -->
                    <div class="form-group">
                        <label for="massa">Massa: </label>
                        <select name="massa" id="massa" class="form-control">
                            <option value="">Selecione a massa</option>
                            <?php foreach ($massas as $massa): ?>
                                <option value="<?= $massa['id'] ?>"><?= $massa["tipo"] ?></option>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <!-- Sabores -->
                    <div class="form-group">
                        <label for="sabores">Sabores: </label>
                        <select multiple name="sabores[]" id="sabores" class="form-control">
                            <?php foreach ($sabores as $sabor): ?>
                                <option value="<?= $sabor['id'] ?>"><?= $sabor["nome"] ?></option>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <!-- Botão de envio -->
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Fazer pedido">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<i class="fas fa-sync-alt"></i>
<i class="fa-solid fa-house"></i>

<?php include_once("templates/footer.php"); ?>
