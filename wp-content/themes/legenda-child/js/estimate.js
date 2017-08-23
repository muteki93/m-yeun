// version: 3.2
jQuery(document).ready(function($){
	
$(".onlynum").keyup(function(){$(this).val( $(this).val().replace(/[^0-9]/g,"") );} );

window.onload = function() {

    // 일단 모든 입력 필드를 사용 불가로 만듬!

    // 다음으로 라디오 버튼에 click 이벤트 핸들러를 붙임!
    var radios = document.forms[0].elements["envelope"];
    for (var i=[0]; i < radios.length; i++) {
        radios[i].onclick = radioClicked;
    }
	
	var radiosPost = document.forms[0].elements["postset"];
	for (var i=[0]; i < radiosPost.length; i++) {
        radiosPost[i].onclick = radioClicked;
    }
	
	var radiosPage = document.forms[0].elements["addPage"];
	for (var i=[0]; i < radiosPage.length; i++) {
        radiosPage[i].onclick = radioClicked;
    }
	
	var radiosPage2 = document.forms[1].elements["postset2"];
	for (var i=[1]; i < radiosPage2.length; i++) {
        radiosPage2[i].onclick = radio2Clicked;
    }
	

}


function radio2Clicked() {
    // 클릭한 라디오 버튼이 무엇인지 확인하고, 그에 따라
    // 알맞은 입력 요소를 사용 가능/불가능으로 전환!
    switch (this.value) {
        case "132" :
		    alert(this.value);
            break;
        case "0" :
		    alert(this.value);
            break;
    }
}


var btnCal1 = document.getElementById('btnCal'); 
var btnCali2 = document.getElementById('btnCal2'); 


btnCal1.onclick = function() {
	
	if ($("input[type=radio][name=addPage]:checked").val() == "one") {
		$subCal = $("select[name=pageNum1]").val() * 1;	
	}
	else if
	 ($("input[type=radio][name=addPage]:checked").val() == "two") {
		$subCal = $("select[name=pageNum2]").val() * 1;	
	}
	else $subCal = 0 ;
	
	
	$mainCal = $("input[type=radio][name=envelope]:checked").val() * 1;
	$postCal = $("input[type=radio][name=postset]:checked").val() * 1;
	$printCal = $("input[type=text][name=printSet]").val() * 1;
	
	
	$printTotal = ($mainCal + $subCal) * $printCal ;
	$postTotal = $postCal * $printCal	
	$totalPlan3 = $printTotal + $postTotal ;
	
	$printTotal = Number($printTotal).toLocaleString('en').split(".")[0];
	$postTotal = Number($postTotal).toLocaleString('en').split(".")[0];
	$totalPlan3 = Number($totalPlan3).toLocaleString('en').split(".")[0];
	

	if( $printCal < 1000) {
		alert("최소 주문량은 1000장 입니다.");
	}
	else {	
	
		//alert('제작료:' + $printTotal + '원(부가세포함) +  배송료:' + $postTotal + '원'); // 이벤트를 제거, 한번만 실행이 됨
		$totalPlan =  '제작료 : ' + $printTotal + '원(부가세포함)' ;
		$totalPlan2 = '우편료 : ' + $postTotal + '원 ' ;
		$totalPlan3 = '합   계 : ' + $totalPlan3 + '원(부가세포함)';
	    $("input[type=text][name=totalPrint]").val($totalPlan);
	    $("input[type=text][name=totalPrint2]").val($totalPlan2);
	    $("input[type=text][name=totalPrint3]").val($totalPlan3);
	}

}

btnCali2.onclick = function() {
	
	$mainCal2 = 80 ;
	$postCal2 = $("input[type=radio][name=postset2]:checked").val() * 1;
	$printCal2 = $("input[type=text][name=printSet2]").val() * 1;
	
	
	$printTotal2 = $mainCal2 * $printCal2 ;
	$postTotal2 = $postCal2 * $printCal2 ;
	$stotalPlan3 = $printTotal2 + $postTotal2 ;
	
	$printTotal2 = Number($printTotal2).toLocaleString('en').split(".")[0];
	$postTotal2 = Number($postTotal2).toLocaleString('en').split(".")[0];
	$stotalPlan3 = Number($stotalPlan3).toLocaleString('en').split(".")[0];
	
	
	
	if( $printCal2 < 1000) {
		alert("최소 주문량은 1000장 입니다.");
	}
	else {
	
		//alert('제작료:' + $printTotal2 + '원(부가세포함) +  배송료:' + $postTotal2 + '원'); // 이벤트를 제거, 한번만 실행이 됨
		$stotalPlan =  '제작료 : ' + $printTotal2 + '원(부가세포함)' ;
		$stotalPlan2 = '우편료 : ' + $postTotal2 + '원';
		$stotalPlan3 = '합   계 : ' + $stotalPlan3 + '원(부가세포함)';
	    $("input[type=text][name=stotalPrint]").val($stotalPlan);
	    $("input[type=text][name=stotalPrint2]").val($stotalPlan2);
	    $("input[type=text][name=stotalPrint3]").val($stotalPlan3);
	}

}


//우선 input을 하나 만듭니다.
 
//<input type="hidden" id="test_id" class="test_class" name="test_name" value="test">
 
//1. id 로 접근해서 가져오기
//= var value = $('#test_id').val();
 
//2. class 로 접근해서 가져오기
//= var value = $('.test_class').val();
 
//3. name으로 접근해서 가져오기
//=var value = $('input[name=test_name]').val();


})(jQuery);
