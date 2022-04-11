<form name="form_search" id="form_search" action="<?php echo base_url()?>search.html" method="post">
    	<fieldset class="main-search">
        	<label>Find a</label>
            <input type="text" name="keyword" value="<?php if(isset($keyword)) echo $keyword;?>" placeholder="eg. bbq, holden, nanny..." />
            <input type="text" name="category" id="project" value="<?php if(isset($category)) echo $category;?>" placeholder="All Categories" />
			
<input type="hidden" id="project-id" name="catslug" value="<?php if(isset($slug) && $slug != "all") echo $slug;?>"  />
            <label>in</label>
            <input type="text" name="address" value="<?php if(isset($city)) echo $city;?>" placeholder="Sate, City or Suburb">
            <input type="submit" value="Search" />
        </fieldset>
    </form>