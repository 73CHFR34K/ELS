<?php
	
	$page = _get("page");
	if(!$page||$page<1) {
		index("?s=".$s."&page=1");
	}

	$pages = ceil(count($users)/$config['users']['perPage']);
	
	if($page>$pages&&$pages!=0) {
		index("?s=".$s."&page=".$pages);
	}
		
	if(count($users)==0) { $doc.='
		<div style="padding: 5px;">There are no users.</div>
	'; } else {
	
	$doc.='
	
	<style>
	
		#content {
			padding: 30px 30px;
		}
		
		#titles {
			border-bottom: 1px solid rgb(150, 200, 0);
		}
	
		#content .first,
		#content .second,
		#content .third,
		#content .fourth {
			padding: 3px 5px;
		}
		
		#content .first {
			width: 50px;
		}
        
        #content .product {
    		width: 290px;
		}
        
        #content .fifth {
        	width: 100px;
		}
		
		#content .second {
			width: 330px;
		}
		
		#content .third {
			width: 180px;
		}
		
		#content .fourth {
			width: 40px;
		}
	
		#content img {
			width: 14px;
			height: 14px;
			padding: 3px 3px;
			position: relative;
			top: 1px;
		}
	
		#content .colored {
			background-color: rgba(0, 0, 0, 0.05);
		}
		
	</style>

	<div id="content">
		<div id="titles">
			<div class="first left">
				ID
			</div>
			<div class="second left">
				HWID
			</div>
            <div class="product left">
    			Produkt
			</div>
			<div class="third left">
				Registriert
			</div>
			<div class="fifth left">
				Lizenz Tage
			</div>
			<div class="fourth left">
				#
			</div>
			
			<div class="clear"></div>
		</div>
		';

			
		$color = false;
		for($i=$config['users']['perPage']*($page-1); $i<=$config['users']['perPage']*($page)-1; $i++) { if($i>=count($users)) { break; } $doc.='
			<div class="element'.($color ? " colored" : "").'">
				<div class="first left">
					'.$users[$i]['id'].'
				</div>
				<div class="second left">
					'.$users[$i]['hwid'].'
				</div>
                <div class="product left">
        		    '.$users[$i]['product'].'
			    </div>
				<div class="third left">
					'.$users[$i]['registered'].'
				</div>
				<div class="fifth left">
					'.$users[$i]['expiredate'].'
				</div>
				<div class="fourth left">
					<img class="left pointer submitFormReset" src="grafik/images/refresh.png" alt="'.$users[$i]['id'].'" title="Reset HWID"></img>
					<img class="left pointer submitFormDelete" src="grafik/images/remove.png" alt="'.$users[$i]['id'].'" title="Delete"></img>
				</div>
				<div class="clear"></div>
			</div>
		'; if(!$color) { $color = true; } else { $color = false; } } $doc.='
		
		<form id="form" action="?s='.$s.'&page='.$page.'" method="post">
			<input type="text" style="display: none;" name="action" value=""></input>
			<input type="text" style="display: none;" name="id" value=""></input>
		</form>
		
		'; if($pages!=1) { $doc.='
			<div style="padding-top: 20px">
				<div class="left" style="width: 80px; min-height: 1px;">
					'; if($page!=1) { $doc.='
						<a href="?s='.$s.'&page='.($page-1).'">previous</a>
					'; } $doc.='
				</div>
				<div class="left" style="width: 580px; min-height: 1px; text-align: center;">
					Page: '.$page.'/'.$pages.'
				</div>
				<div class="left" style="width: 80px; min-height: 1px; text-align: right;">
					'; if($page!=$pages) { $doc.='
						<a href="?s='.$s.'&page='.($page+1).'">next</a>
					'; } $doc.='
				</div>
				<div class="clear"></div>
			</div>
		'; } $doc.='
		
		
	</div>
	
	';
	
	}

?>