<h1>Динамическая загрузка спрайтов</h1>
<div class="date">01.01.2007</div>

<p>Динамическая загрузка спрайтов</p>
<p>Если делать игру с большим количеством графических изображений, то неразумно будет загружать их все сразу, например зачем в основном меню игры графика босса с последнего уровня? А вот памяти его "фото" будет жрать! Чтобы этого непроисходило необходимо разделить всю игру на сцены, и просто при загрузке конкретной сцены удалять из памяти ненужные картинки и загружать туда только те которые в этой сцене используются. Делаем это так:<br>
<p>При загрузке сцены пишем:</p>
<pre>
loadpicdata(DxImagelist1 {Вместо DxImagelist1 имя вашего TdxImageLista},'Menu' {Тут название файла со списком используемых картинок данной сцены});
</pre>
<p>Формат файла со списком такой:<br>
[название] (название одинаково с именем файла, только без расширения)<br>
PictureHeight=800 (Высота картинки)<br>
PictureWidth=600 (Ширина картинки)<br>
PatternHeight=0 (Высота кадра (если в картинке несколько кадров)) <br>
PatternWidth=0 (Ширина кадра)<br>
SkipHeight=0 (Пропуск высоты, пусть останеться 0)<br>
SkipWidth=0 (Пропуск ширины, пусть останеться 0)<br>
SystemMemory=0 (Пока не надо, пусть останеться 0)<br>
Transparent=0 (Прозрачен или нет)<br>
TransparentColor=clBlack (Цвет прозрачности)<br>
&nbsp;<br>
<p>Например кусочек файла "game.dat":</p>
<pre>[enemy]<br>
PictureHeight=96<br>
PictureWidth=192<br>
PatternHeight=0<br>
PatternWidth=48<br>
SkipHeight=0<br>
SkipWidth=0<br>
SystemMemory=0<br>
Transparent=1<br>
TransparentColor=$00FF8040
</pre>


<p>При этом файлы должны лежать в папке Pictures\Bmp (если они Bitmapы) или Pictures\Jpg (если они в Jpeg).<br>
Ещё файлы со списком должны лежать в Pictures\Data<br>
&nbsp;<br>
А вот и сама процедура загрузки:<br>
&nbsp;<br>
<p>PS. В USES надо дописать DIB, Jpeg, iniFiles</p>
<pre>Procedure TForm1.LoadPicData( var DXImageList : TDXImageList; FileName : string);
Var
 i : integer;
 Item : TPictureCollectionItem;
 SectionName : string;
 Ident : string;
 NewGraphic : TDIB;
 BitMap : TBitMap;
 PicFileName : string;
 SectionList : TStringList;
 JpgImg : TJPEGImage;
 Ext : String;
&nbsp;
Function GetName(InDir,InFileName : string): string ;
Var
 OutFileName : string;
begin
 Result:='';
 OutFileName:=ExtractFilePath(Application.ExeName)+InDir+'\'+InFileName ;
 Result:=OutFileName;
 Exit;
 OutFileName:='c:\'+InDir+'\'+InFileName;
 if FileExists(OutFileName) then
 begin
 &nbsp; Result:=OutFileName;
 &nbsp; Exit;
 end;
end;
&nbsp;
begin
 DXImageList.Items.Clear; //Очищаем память от картинок
 FileName:=ChangeFileExt(FileName,'.dat');
 NewGraphic:=TDIB.Create;
 BitMap:=TBitMap.Create;
 SectionList:=TStringList.Create;
 try //Читаем файл со списком изображений
 &nbsp; With TIniFile.Create(GetName('Pictures\data',FileName)) do
 &nbsp; try
 &nbsp;&nbsp; ReadSections(SectionList);
 &nbsp;&nbsp; For i:=0 to SectionList.Count-1 do
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; SectionName:=SectionList[i];
 &nbsp;&nbsp;&nbsp;&nbsp; //Пытаемся определить формат картинки
 &nbsp;&nbsp;&nbsp;&nbsp; Ext:='bmp';
 &nbsp;&nbsp;&nbsp;&nbsp; PicFileName:=GetName('Pictures',Ext+'\'+SectionName+'.'+Ext);
 &nbsp;&nbsp;&nbsp;&nbsp; if FileExists(PicFileName) then
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NewGraphic.LoadFromFile(PicFileName);
 &nbsp;&nbsp;&nbsp;&nbsp; else
 &nbsp;&nbsp;&nbsp;&nbsp; if not (FileExists(PicFileName)) then
 &nbsp;&nbsp;&nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ext:='jpg';
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PicFileName:=GetName('Pictures\Jpg\',SectionName+'.'+Ext);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JpgImg:=TJPEGImage.Create;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; try
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JpgImg.LoadFromFile(PicFileName);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NewGraphic.Assign(JpgImg);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; finally
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JpgImg.Free;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; end;
 &nbsp;&nbsp;&nbsp;&nbsp; end;
 &nbsp;&nbsp;&nbsp;&nbsp; //Добавляем картинку в память
 &nbsp;&nbsp;&nbsp;&nbsp; Item := TPictureCollectionItem.Create(DXImageList.Items);
 &nbsp;&nbsp;&nbsp;&nbsp; Item.Picture.Graphic := NewGraphic;
 &nbsp;&nbsp;&nbsp;&nbsp; Item.Name:=SectionName;
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='PatternHeight';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.PatternHeight:=ReadInteger(SectionName,Ident,0);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='PatternWidth';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.PatternWidth:=ReadInteger(SectionName,Ident,0);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='SkipHeight';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.SkipHeight:=ReadInteger(SectionName,Ident,0);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='SkipWidth';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.SkipWidth:=ReadInteger(SectionName,Ident,0);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='SystemMemory';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.SystemMemory:=ReadBool(SectionName,Ident,false);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='Transparent';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.Transparent:=ReadBool(SectionName,Ident,false);
 &nbsp;&nbsp;&nbsp;&nbsp; Ident:='TransparentColor';
 &nbsp;&nbsp;&nbsp;&nbsp; Item.TransparentColor:=StringToColor(ReadString(SectionName,Ident,'clBlack'));
 &nbsp;&nbsp;&nbsp;&nbsp; Item.Restore;
 &nbsp;&nbsp; end;
 &nbsp; Finally
 &nbsp;&nbsp; Free;
 &nbsp; end;
 Finally
 &nbsp; NewGraphic.Free;
 &nbsp; BitMap.Free;
 &nbsp; SectionList.Free;
 end;
end;
</pre>


<p><a href="https://www.mirgames.ru" target="_blank">https://www.mirgames.ru</a></p>
<div class="author">Автор: Spose</div>
