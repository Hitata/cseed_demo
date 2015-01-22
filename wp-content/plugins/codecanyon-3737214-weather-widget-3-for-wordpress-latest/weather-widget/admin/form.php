<p>
    <label for="<?php echo $this->get_field_id("title"); ?>">
        <?php _e("Title","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("title"); ?>"
                  name="<?php echo $this->get_field_name("title"); ?>"
                  value="<?php echo isset($instance["title"]) ? esc_attr($instance["title"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("apikey"); ?>">
        <?php _e("API Key","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("apikey"); ?>"
                  name="<?php echo $this->get_field_name("apikey"); ?>"
                  value="<?php echo isset($instance["apikey"]) ? esc_attr($instance["apikey"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("width"); ?>">
        <?php _e("Widget Width","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("width"); ?>"
                  name="<?php echo $this->get_field_name("width"); ?>"
                  value="<?php echo isset($instance["width"]) ? esc_attr($instance["width"]) : "180px"; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("location"); ?>">
        <?php _e("Latitude and longitude of the location","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("location"); ?>"
                  name="<?php echo $this->get_field_name("location"); ?>"
                  value="<?php echo isset($instance["location"]) ? esc_attr($instance["location"]) : "51.5063,-0.1271"; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("locationname"); ?>">
        <?php _e("Location name as seen by users","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("locationname"); ?>"
                  name="<?php echo $this->get_field_name("locationname"); ?>"
                  value="<?php echo isset($instance["locationname"]) ? esc_attr($instance["locationname"]) : "London, England"; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("units"); ?>">
        <?php _e("Temperature Units","ww3"); ?>:
        <select id="<?php echo $this->get_field_id("units"); ?>" name="<?php echo $this->get_field_name("units"); ?>" class="widefat">
            <option <?php echo isset($instance["units"]) && $instance["units"] == "C" ? "selected" : ""; ?> value="C"><?php _e("Celsius","ww3"); ?></option>
            <option <?php echo isset($instance["units"]) && $instance["units"] == "F" ? "selected" : ""; ?> value="F"><?php _e("Fahrenheit","ww3"); ?></option>
        </select>
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("icons"); ?>">
        <?php _e("Icons Color","ww3"); ?>:
        <select id="<?php echo $this->get_field_id("icons"); ?>" name="<?php echo $this->get_field_name("icons"); ?>" class="widefat">
            <option <?php echo isset($instance["icons"]) && $instance["icons"] == "white" ? "selected" : ""; ?> value="white"><?php _e("White","ww3"); ?></option>
            <option <?php echo isset($instance["icons"]) && $instance["icons"] == "black" ? "selected" : ""; ?> value="black"><?php _e("Black","ww3"); ?></option>
        </select>
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("frontbg"); ?>">
        <?php _e("Front Background Color","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("frontbg"); ?>"
                  name="<?php echo $this->get_field_name("frontbg"); ?>"
                  value="<?php echo isset($instance["frontbg"]) ? esc_attr($instance["frontbg"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("fronttxt"); ?>">
        <?php _e("Front Text Color","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("fronttxt"); ?>"
                  name="<?php echo $this->get_field_name("fronttxt"); ?>"
                  value="<?php echo isset($instance["fronttxt"]) ? esc_attr($instance["fronttxt"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("backtopbg"); ?>">
        <?php _e("Forecast Top Background Color","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("backtopbg"); ?>"
                  name="<?php echo $this->get_field_name("backtopbg"); ?>"
                  value="<?php echo isset($instance["backtopbg"]) ? esc_attr($instance["backtopbg"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("backbg"); ?>">
        <?php _e("Forecast Background Color","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("backbg"); ?>"
                  name="<?php echo $this->get_field_name("backbg"); ?>"
                  value="<?php echo isset($instance["backbg"]) ? esc_attr($instance["backbg"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>

<p>
    <label for="<?php echo $this->get_field_id("backtxt"); ?>">
        <?php _e("Forecast Text Color","ww3"); ?>:
        <input    id="<?php echo $this->get_field_id("backtxt"); ?>"
                  name="<?php echo $this->get_field_name("backtxt"); ?>"
                  value="<?php echo isset($instance["backtxt"]) ? esc_attr($instance["backtxt"]) : ""; ?>"
                  class="widefat"
        />
    </label>
</p>