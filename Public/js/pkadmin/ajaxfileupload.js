var html = '';
var i=0;
var uploadRUL = '/Pkadmin/Article/upload';
var updateRUL = '/Pkadmin/Article/update';
function addPic() {
    i++;
    tyid ='#article_pic'+i;
    var input = '<input id=' + tyid + ' type="file" class="default" accept="images/*"  name="article_pic" value="上传" />'
    var picInut = $('showImg');
    picInut.append(input);
    $("#input").on("change", tyid, upload)
}

$(function () {
    $("#article_pic").change(upload);
});


function del() {
    $("#showImg").on("click", ".dd", function(e){
        $(e.target).parent().remove()
    });
    $("#oringinImg").on("click", ".dd", function(e){
        $(e.target).parent().remove()
    });
}

function upload () {
    var formData = new FormData();
    formData.append("article_pic", document.getElementById("article_pic").files[0]);
    $.ajax({
        url: uploadRUL,
        type: "POST",
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        timeout : 2000
    })
    .done(function(data) {
        // 请求成功后要做的工作
        console.log(data);
        html += '<div class="thumbnail"><img src='+ data.url+'>' +'<button class="dd btn btn-danger" type="button" onclick="del()"> 删除 </button></div>' + '<br>';
        $('#showImg').html(html);
        addPic();
    })
    .fail(function(xhr) {
        console.log('error:' + JSON.stringify(xhr));
    })
    .always(function() {
        //console.log('complete');
    });
}
//$(document).ready(function(){});
$('form').on('submit', function (e) {
    e.preventDefault();
    var imgArr = []
    $('.col-sm-3 img').each(function(i, img){
        imgArr.push(img.src)
    });
    console.log(imgArr);
    article_pic = JSON.stringify(imgArr);
    id = $("#id").val();
    category_id = $('[name="category_id"]').val();
    article_title = $("#article_title").val();
    keywords = $("#keywords").val();
    article_desc = $("#article_desc").val();
    content = $("#content").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("category_id", category_id);
    formData.append("article_title", article_title);
    formData.append("keywords", keywords);
    formData.append("article_desc", article_desc);
    formData.append("content", content);
    formData.append("article_pic", article_pic);
    if (article_title == ''){
        alert("请输入文章名称！");
        return false;
    }
    if (article_pic == ''){
        alert("请输入文章正文内容！");
        return false;
    }
    $.ajax({
        url: updateRUL,
        type: "POST",
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        timeout : 2000
    })
    .done(function (data) {
        alert(data.msg);
        console.log("success");
    })
    .fail(function (xhr) {
        // 请求失败后要做的工作
        console.log('fail:' + JSON.stringify(xhr));
    })
    .always(function () {
        //console.log('complete');
    });
    return false;
});
