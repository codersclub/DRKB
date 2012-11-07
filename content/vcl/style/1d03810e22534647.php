<h1>Добавление картинки на кнопку, если используются стили XP</h1>
<div class="date">01.01.2007</div>


<pre>

function Button_SetImageEx(hwndCtl:HWND; 
                           Img:HGDIOBJ; 
                           ImgType:integer; // IMAGE_BITMAP или IMAGE_ICON
                           cx:integer = 16; cy:integer = 16):Integer;
const
 BCM_FIRST                       = $1600;
 BCM_SETIMAGELIST                = $0002;
 
 BUTTON_IMAGELIST_ALIGN_LEFT     = 0;
 BUTTON_IMAGELIST_ALIGN_RIGHT    = 1;
 BUTTON_IMAGELIST_ALIGN_TOP      = 2;
 BUTTON_IMAGELIST_ALIGN_BOTTOM   = 3;
 BUTTON_IMAGELIST_ALIGN_CENTER   = 4;
 
type
 TButtonImageList=record
   himl   : HIMAGELIST;    // normal, hot, pushed, disabled, focused
   margin : TRECT;         // отступы 
   uAlign : DWORD;         // выравнивание 
 end;
 
var
   hIconBlend:HICON;
   bi:TButtonImageList;
begin
    Result:=0;
    if not (ImgType in [IMAGE_BITMAP,IMAGE_ICON]) then exit;
 
    ZeroMemory(@bi, sizeof(bi));
    bi.himl := ImageList_Create(cx,cy,ILC_COLOR16 or ILC_MASK,4,0);
    bi.margin.Left:=10;
    bi.uAlign := BUTTON_IMAGELIST_ALIGN_LEFT;
 
    if (ImgType=IMAGE_BITMAP) then
    begin
     ImageList_Add(bi.himl,Img,0);   // Normal
     ImageList_Add(bi.himl,Img,0);   // hot
     ImageList_Add(bi.himl,Img,0);   // pushed
    end else
    begin
     ImageList_AddIcon(bi.himl,Img);   // Normal
     ImageList_AddIcon(bi.himl,Img);   // hot
     ImageList_AddIcon(bi.himl,Img);   // pushed
    end;
 
    // disabled
    hIconBlend := ImageList_GetIcon(bi.himl,0,ILD_BLEND50 or ILD_TRANSPARENT);
    ImageList_AddIcon(bi.himl,hIconBlend);
    DestroyIcon(hIconBlend);
 
    // focused
    if (ImgType=IMAGE_BITMAP) then ImageList_Add(bi.himl,Img,0) else
    ImageList_AddIcon(bi.himl,Img);
 
 
    result:=SendMessage(hwndCtl,BCM_FIRST + BCM_SETIMAGELIST,0,LPARAM(@bi));
    if (result=0) then
    begin
     ImageList_Destroy(bi.himl);
     result := SendMessage(hwndCtl,BM_SETIMAGE,ImgType,Img)
    end;
end;
</pre>
<p> <br>
<p>Пример использования:</p>
<pre>
// bitmap
 SetWindowLong(hwndButton,GWL_STYLE,GetWindowLong(hwndButton,GWL_STYLE) or BS_BITMAP);          
 Button_SetImageEx(hwndButton,LoadBitmap(hInstance,'IDB_BITMAP1'),IMAGE_BITMAP);
// иконка
 SetWindowLong(hwndButton,GWL_STYLE,GetWindowLong(hwndButton,GWL_STYLE) or BS_ICON);
 Button_SetImageEx(hwndButton,LoadIcon(hInstance,'IDI_ICON1'),IMAGE_ICON);
 
</pre>
<p> <br>
<div class="author">Автор: Krid</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
