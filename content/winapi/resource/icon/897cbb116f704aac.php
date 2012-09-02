<h1>Как сохранить иконку в файл имея её хендл?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Windows,ActiveX;

 
function OleSavePictureFile(dispPicture: IDispatch; bstrFileName: TBStr): HResult; stdcall;
                                                                        external 'oleaut32.dll';
 
// icon - дескриптор иконки
// FileName - файл, в который сохранять
// DestroyAfterSave - уничтожать дескриптор иконки после сохранения или нет
function StoreIconFile(icon:HICON; FileName:string; DestroyAfterSave:boolean=false):boolean;
const
 IID_IPictureDisp:TGUID = '{7BF80981-BF32-101A-8BBB-00AA00300CAB}';
var
 pd:TPictDesc;
 ipd:IPictureDisp;
begin
 pd.cbSizeofstruct:=sizeof(TPictDesc);
 pd.picType:=PICTYPE_ICON;
 pd.hIcon:=icon;
 result:=(OleCreatePictureIndirect(pd,IID_IPictureDisp,DestroyAfterSave,ipd)=S_OK) and
         (OleSavePictureFile(ipd, StringToOLEStr(FileName))=S_OK)
end;
</pre>
&nbsp;</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Krid</p>
