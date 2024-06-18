---
Title: Динамическая загрузка спрайтов
Author: Spose, <https://www.mirgames.ru>
Date: 01.01.2007
---


Динамическая загрузка спрайтов
==============================

Если делать игру с большим количеством графических изображений, то
неразумно будет загружать их все сразу, например зачем в основном меню
игры графика босса с последнего уровня? А вот памяти его "фото" будет
жрать! Чтобы этого непроисходило необходимо разделить всю игру на сцены,
и просто при загрузке конкретной сцены удалять из памяти ненужные
картинки и загружать туда только те которые в этой сцене используются.
Делаем это так:

При загрузке сцены пишем:

    loadpicdata(DxImagelist1 {Вместо DxImagelist1 имя вашего TdxImageLista},
                'Menu' {Тут название файла со списком используемых картинок данной сцены});

Формат файла со списком такой:

    [название] (название одинаково с именем файла, только без расширения)
    PictureHeight=800 (Высота картинки)
    PictureWidth=600 (Ширина картинки)
    PatternHeight=0 (Высота кадра (если в картинке несколько кадров))
    PatternWidth=0 (Ширина кадра)
    SkipHeight=0 (Пропуск высоты, пусть останеться 0)
    SkipWidth=0 (Пропуск ширины, пусть останеться 0)
    SystemMemory=0 (Пока не надо, пусть останеться 0)
    Transparent=0 (Прозрачен или нет)
    TransparentColor=clBlack (Цвет прозрачности)


Например кусочек файла "game.dat":

    [enemy]
    PictureHeight=96
    PictureWidth=192
    PatternHeight=0
    PatternWidth=48
    SkipHeight=0
    SkipWidth=0
    SystemMemory=0
    Transparent=1
    TransparentColor=$00FF8040

При этом файлы должны лежать в папке Pictures\\Bmp (если они Bitmapы)
или Pictures\\Jpg (если они в Jpeg).
Ещё файлы со списком должны лежать в Pictures\\Data

А вот и сама процедура загрузки:

**PS.** В USES надо дописать DIB, Jpeg, iniFiles

    Procedure TForm1.LoadPicData( var DXImageList : TDXImageList; FileName : string);
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
       Result:=OutFileName;
       Exit;
     end;
    end;
     
    begin
     DXImageList.Items.Clear; //Очищаем память от картинок
     FileName:=ChangeFileExt(FileName,'.dat');
     NewGraphic:=TDIB.Create;
     BitMap:=TBitMap.Create;
     SectionList:=TStringList.Create;
     try //Читаем файл со списком изображений
       With TIniFile.Create(GetName('Pictures\data',FileName)) do
       try
        ReadSections(SectionList);
        For i:=0 to SectionList.Count-1 do
        begin
          SectionName:=SectionList[i];
          //Пытаемся определить формат картинки
          Ext:='bmp';
          PicFileName:=GetName('Pictures',Ext+'\'+SectionName+'.'+Ext);
          if FileExists(PicFileName) then
           NewGraphic.LoadFromFile(PicFileName);
          else
          if not (FileExists(PicFileName)) then
          begin
           Ext:='jpg';
           PicFileName:=GetName('Pictures\Jpg\',SectionName+'.'+Ext);
           JpgImg:=TJPEGImage.Create;
           try
             JpgImg.LoadFromFile(PicFileName);
             NewGraphic.Assign(JpgImg);
           finally
             JpgImg.Free;
           end;
          end;
          //Добавляем картинку в память
          Item := TPictureCollectionItem.Create(DXImageList.Items);
          Item.Picture.Graphic := NewGraphic;
          Item.Name:=SectionName;
          Ident:='PatternHeight';
          Item.PatternHeight:=ReadInteger(SectionName,Ident,0);
          Ident:='PatternWidth';
          Item.PatternWidth:=ReadInteger(SectionName,Ident,0);
          Ident:='SkipHeight';
          Item.SkipHeight:=ReadInteger(SectionName,Ident,0);
          Ident:='SkipWidth';
          Item.SkipWidth:=ReadInteger(SectionName,Ident,0);
          Ident:='SystemMemory';
          Item.SystemMemory:=ReadBool(SectionName,Ident,false);
          Ident:='Transparent';
          Item.Transparent:=ReadBool(SectionName,Ident,false);
          Ident:='TransparentColor';
          Item.TransparentColor:=StringToColor(ReadString(SectionName,Ident,'clBlack'));
          Item.Restore;
        end;
       Finally
        Free;
       end;
     Finally
       NewGraphic.Free;
       BitMap.Free;
       SectionList.Free;
     end;
    end;


