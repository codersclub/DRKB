---
Title: Двоичный файл с набором изображений
Author: Ed Jordan
Date: 01.01.2007
---


Двоичный файл с набором изображений
===================================

::: {.date}
01.01.2007
:::

Автор: Ed Jordan

Может кто-либо обеспечить меня хорошим примером как сохранить множество
изображений в единственном бинарном файле?

Хорошо, вот пример. Я не могу сказать что это лучшее решение, но это
работает. Я надеюсь данный совет побудит моих читателей придумать более
мудрое решение, коротое я потом и опубликую.

Данный пример помещает вашу запись в объект. Хотя это и не было строго
необходимым, я сконфигурировал алгоритм именно так, потому что рано или
поздно вы это сделаете... В качестве средства для чтения и записи он
использует потоки. Возможно вы уже использовали потоки, поэтому моя
технология не будет для вас открытием. Одно из преимуществ использования
потока в том, что для работы с графическими объектами -- bitmap, icon,
metafile -- можно использовать методы SaveToStream и LoadFromStream.

У меня была проблема с использованием LoadFromStream, и она была похожей
на вашу. При вызове Graphic.LoadFromStream, графика "оставляла"
позицию потока с самом его конце, а не в конце записи. Другими словами,
если графический объект первый раз записывал себя в поток, данные
заканчивались в позиции 247. Но когда графический объект "читал себя",
он не останавливался в позиции 247, а читал себя из всего потока.
Поэтому мог быть прочитан только один объект.

Мое решение проблемы заключается в установке позиции, на которой
действительно заканчивается запись. Затем, после того как графический
объект прочтет себя из потока, я снова перемещаю позицию, готовя тем
самым поток для чтения следующего объекта. Эти детали делают реализацию
объекта чуть сложнее. Вот и всё, код смотрите ниже.

Кое-то еще:
я сделал объект способным обрабатывать иконки, метафайлы, а
также простые изображения. Не знаю, понадобится ли вам это, и может
быть я выбрал не самое элегантное решение...

    unit Unit2;
     
    interface
    uses Graphics, Classes;
     
    type
      TAlbumRec = class
      private
        FGraphic: TGraphic;
        FDescription: string; { ...Просто пример поля }
        FItemType: ShortInt;  { ...Просто пример поля }
        procedure SetGraphic(AGraphic: TGraphic);
      public
        constructor Create;
        destructor Destroy; override;
        procedure LoadFromStream(Stream: TStream);
        procedure SaveToStream(Stream: TStream);
        property Graphic: TGraphic read FGraphic write SetGraphic;
        property Description: string read FDescription write FDescription;
        property ItemType: ShortInt read FItemType write FItemType;
      end;
     
    implementation
     
    constructor TAlbumRec.Create;
    begin
      inherited Create;
    end;
     
    destructor TAlbumRec.Destroy;
    begin
      FGraphic.Free;
      inherited Destroy;
    end;
     
    procedure TAlbumRec.LoadFromStream(Stream: TStream);
    var
      GraphicTypeCode: Char;
      EndPosition: LongInt;
    begin
      { Считываем в потоке позицию где заканчивается запись... }
      Stream.Read(EndPosition, SizeOf(EndPosition));
     
      { Считываем в Delphi 1.0 строку... }
      Stream.Read(FDescription[0], SizeOf(Byte));
      Stream.Read(FDescription[1], Byte(FDescription[0]));
     
      { Читаем целое... }
      Stream.Read(FItemType, SizeOf(FItemType));
     
      { Считываем код, сообщающий тип графического объекта,
      который необходимо создать... }
      Stream.Read(GraphicTypeCode, SizeOf(GraphicTypeCode));
     
      { Освобождаем текущий графический объект и пересоздаем его.. }
      FGraphic.Free;
      FGraphic := nil;
      case GraphicTypeCode of
        'B': FGraphic := TBitmap.Create;
        'I': FGraphic := TIcon.Create;
        'M': FGraphic := TMetafile.Create;
      end;
     
      { Загружаем из потока графику... }
      if FGraphic <> nil then
        FGraphic.LoadFromStream(Stream);
     
      { Ищем в потоке конечную позицию для данной записи. Почему мы это делаем?
      Я обнаружил это, когда графический объект читал себя из потока, и при этом
      "оставлял" позицию потока с самом его конце, а не в конце записи. Поэтому
      мог быть прочитан только один объект... }
      Stream.Seek(EndPosition, 0);
    end;
     
    procedure TAlbumRec.SaveToStream(Stream: TStream);
    var
      GraphicTypeCode: Char;
      StartPosition,
        EndPosition: LongInt;
    begin
      { Запоминаем позицию потока для дальнейшей записи наших объектов... }
      StartPosition := Stream.Position;
     
      { Здесь мы собираемся записать позицию где заканчиваются данные записи.
      Мы пока не знаем как это позиционируется, поэтому пока записываем ноль
      чтобы сохранить место... }
      EndPosition := 0;
      Stream.Write(EndPosition, SizeOf(EndPosition));
     
      { Записываем строку Delphi 1.0... }
      Stream.Write(FDescription[0], SizeOf(Byte));
      Stream.Write(FDescription[1], Byte(FDescription[0]));
     
      { Записываем целое... }
      Stream.Write(FItemType, SizeOf(FItemType));
     
      { Записываем код, сообщающий тип графического объекта,
      который мы собираемся писать... }
      if (FGraphic = nil) or (FGraphic.Empty) then
        GraphicTypeCode := 'Z'
      else if FGraphic is TBitmap then
        GraphicTypeCode := 'B'
      else if FGraphic is TIcon then
        GraphicTypeCode := 'I'
      else if FGraphic is TMetaFile then
        GraphicTypeCode := 'M';
      Stream.Write(GraphicTypeCode, SizeOf(GraphicTypeCode));
     
      { Записываем графику... }
      if (GraphicTypeCode <> 'Z') then
        FGraphic.SaveToStream(Stream);
     
      { Возвращаемся к месту откуда мы начинали и записываем
      конечную позицию, которую мы сохранили... }
      EndPosition := Stream.Position;
      Stream.Seek(StartPosition, 0);
      Stream.Write(EndPosition, SizeOf(EndPosition));
     
      { Возвращаем конечную позицию, после этого поток готов
      для следующей записи... }
      Stream.Seek(EndPosition, 0);
    end;
     
    procedure TAlbumRec.SetGraphic(AGraphic: TGraphic);
    begin
      FGraphic.Free;
      FGraphic := nil;
      if AGraphic <> nil then
      begin
        FGraphic := TGraphic(AGraphic.ClassType.Create);
        FGraphic.Assign(AGraphic);
      end;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
