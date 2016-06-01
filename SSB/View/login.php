<div class="login">	
	<form method="post" action="/admin/login">
        <div class="inline">
            <input class="field" type="text" id="username" name="username" required>
            <label class="label" for="username">Username</label>
        </div>
        <div class="inline">
            <input class="field" type="password" id="password" name="password" required>
            <label class="label" for="password">Passwort</label>
        </div>
        <div class="inline">
          <button type="submit" class="button">
            login
          </button>
        </div>
        <?php
        if($this->fail == true) {
          echo "
          <div class=\"label\">
          <p id=\"fail\">$this->failText</p>
          </div>";
        }
        ?>
	</form>
</div>