---
Title: Как сохранить значение свойства в поток?
Date: 01.01.2007
---


Как сохранить значение свойства в поток?
========================================

Вариант 1:

Author: Rick Rogers

How can I save properties of a TList to a stream? I need the entire list
to be saved as a whole and not as individual objects.

A TList doesn\'t have any intrinsic streaming capability built into it,
but it is very easy to stream anything that you want with a little elbow
grease. Think about it: a stream is data. Classes have properties, whose
values are data. It isn\'t too hard to write property data to a stream.
Here\'s a simple example to get you going. This is but just one of many
possible approaches to saving object property data to a stream:

    unit uStreamableExample;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls, Contnrs;
     
    type
      TStreamableObject = class(TPersistent)
      protected
        function ReadString(Stream: TStream): String;
        function ReadLongInt(Stream: TStream): LongInt;
        function ReadDateTime(Stream: TStream): TDateTime;
        function ReadCurrency(Stream: TStream): Currency;
        function ReadClassName(Stream: TStream): ShortString;
        procedure WriteString(Stream: TStream; const Value: String);
        procedure WriteLongInt(Stream: TStream; const Value: LongInt);
        procedure WriteDateTime(Stream: TStream; const Value: TDateTime);
        procedure WriteCurrency(Stream: TStream; const Value: Currency);
        procedure WriteClassName(Stream: TStream; const Value: ShortString);
      public
        constructor CreateFromStream(Stream: TStream);
        procedure LoadFromStream(Stream: TStream); virtual; abstract;
        procedure SaveToStream(Stream: TStream); virtual; abstract;
      end;
     
      TStreamableObjectClass = class of TStreamableObject;
     
      TPerson = class(TStreamableObject)
      private
        FName: String;
        FBirthDate: TDateTime;
      public
        constructor Create(const AName: string; ABirthDate: TDateTime);
        procedure LoadFromStream(Stream: TStream); override;
        procedure SaveToStream(Stream: TStream); override;
        property Name: String read FName write FName;
        property BirthDate: TDateTime read FBirthDate write FBirthDate;
      end;
     
      TCompany = class(TStreamableObject)
      private
        FName: String;
        FRevenues: Currency;
        FEmployeeCount: LongInt;
      public
        constructor Create(const AName: string; ARevenues: Currency; AEmployeeCount: LongInt);
        procedure LoadFromStream(Stream: TStream); override;
        procedure SaveToStream(Stream: TStream); override;
        property Name: String read FName write FName;
        property Revenues: Currency read FRevenues write FRevenues;
        property EmployeeCount: LongInt read FEmployeeCount write FEmployeeCount;
      end;
     
      TStreamableList = class(TStreamableObject)
      private
        FItems: TObjectList;
        function Get_Count: LongInt;
        function Get_Objects(Index: LongInt): TStreamableObject;
      public
        constructor Create;
        destructor Destroy; override;
        function FindClass(const AClassName: String): TStreamableObjectClass;
        procedure Add(Item: TStreamableObject);
        procedure Delete(Index: LongInt);
        procedure Clear;
        procedure LoadFromStream(Stream: TStream); override;
        procedure SaveToStream(Stream: TStream); override;
        property Objects[Index: LongInt]: TStreamableObject read Get_Objects; default;
        property Count: LongInt read Get_Count;
      end;
     
      TForm1 = class(TForm)
        SaveButton: TButton;
        LoadButton: TButton;
        procedure SaveButtonClick(Sender: TObject);
        procedure LoadButtonClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        Path: String;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    resourcestring
      DEFAULT_FILENAME = 'test.dat';
     
    procedure TForm1.SaveButtonClick(Sender: TObject);
    var
      List: TStreamableList;
      Stream: TStream;
    begin
      List := TStreamableList.Create;
      try
        List.Add(TPerson.Create('Rick Rogers', StrToDate('05/20/68')));
        List.Add(TCompany.Create('Fenestra', 1000000, 7));
        Stream := TFileStream.Create(Path + DEFAULT_FILENAME, fmCreate);
        try
          List.SaveToStream(Stream);
        finally
          Stream.Free;
        end;
      finally
        List.Free;
      end;
    end;
     
    { TPerson }
     
    constructor TPerson.Create(const AName: string; ABirthDate: TDateTime);
    begin
      inherited Create;
      FName := AName;
      FBirthDate := ABirthDate;
    end;
     
    procedure TPerson.LoadFromStream(Stream: TStream);
    begin
      FName := ReadString(Stream);
      FBirthDate := ReadDateTime(Stream);
    end;
     
    procedure TPerson.SaveToStream(Stream: TStream);
    begin
      WriteString(Stream, FName);
      WriteDateTime(Stream, FBirthDate);
    end;
     
    { TStreamableList }
     
    procedure TStreamableList.Add(Item: TStreamableObject);
    begin
      FItems.Add(Item);
    end;
     
    procedure TStreamableList.Clear;
    begin
      FItems.Clear;
    end;
     
    constructor TStreamableList.Create;
    begin
      FItems := TObjectList.Create;
    end;
     
    procedure TStreamableList.Delete(Index: LongInt);
    begin
      FItems.Delete(Index);
    end;
     
    destructor TStreamableList.Destroy;
    begin
      FItems.Free;
      inherited;
    end;
     
    function TStreamableList.FindClass(const AClassName: String): TStreamableObjectClass;
    begin
      Result :=  TStreamableObjectClass(Classes.FindClass(AClassName));
    end;
     
    function TStreamableList.Get_Count: LongInt;
    begin
      Result := FItems.Count;
    end;
     
    function TStreamableList.Get_Objects(Index: LongInt): TStreamableObject;
    begin
      Result := FItems[Index] as TStreamableObject;
    end;
     
    procedure TStreamableList.LoadFromStream(Stream: TStream);
    var
      StreamCount: LongInt;
      I: Integer;
      S: String;
      ClassRef: TStreamableObjectClass;
    begin
      StreamCount := ReadLongInt(Stream);
      for I := 0 to StreamCount - 1 do
      begin
        S := ReadClassName(Stream);
        ClassRef := FindClass(S);
        Add(ClassRef.CreateFromStream(Stream));
      end;
    end;
     
    procedure TStreamableList.SaveToStream(Stream: TStream);
    var
      I: Integer;
    begin
      WriteLongInt(Stream, Count);
      for I := 0 to Count - 1 do
      begin
        WriteClassName(Stream, Objects[I].ClassName);
        Objects[I].SaveToStream(Stream);
      end;
    end;
     
    { TStreamableObject }
     
    constructor TStreamableObject.CreateFromStream(Stream: TStream);
    begin
      inherited Create;
      LoadFromStream(Stream);
    end;
     
    function TStreamableObject.ReadClassName(Stream: TStream): ShortString;
    begin
      Result := ReadString(Stream);
    end;
     
    function TStreamableObject.ReadCurrency(Stream: TStream): Currency;
    begin
      Stream.Read(Result, SizeOf(Currency));
    end;
     
    function TStreamableObject.ReadDateTime(Stream: TStream): TDateTime;
    begin
      Stream.Read(Result, SizeOf(TDateTime));
    end;
     
    function TStreamableObject.ReadLongInt(Stream: TStream): LongInt;
    begin
      Stream.Read(Result, SizeOf(LongInt));
    end;
     
    function TStreamableObject.ReadString(Stream: TStream): String;
    var
      L: LongInt;
    begin
      L := ReadLongInt(Stream);
      SetLength(Result, L);
      Stream.Read(Result[1], L);
    end;
     
    procedure TStreamableObject.WriteClassName(Stream: TStream; const Value: ShortString);
    begin
      WriteString(Stream, Value);
    end;
     
    procedure TStreamableObject.WriteCurrency(Stream: TStream; const Value: Currency);
    begin
      Stream.Write(Value, SizeOf(Currency));
    end;
     
    procedure TStreamableObject.WriteDateTime(Stream: TStream; const Value: TDateTime);
    begin
      Stream.Write(Value, SizeOf(TDateTime));
    end;
     
    procedure TStreamableObject.WriteLongInt(Stream: TStream; const Value: LongInt);
    begin
      Stream.Write(Value, SizeOf(LongInt));
    end;
     
     
    procedure TStreamableObject.WriteString(Stream: TStream; const Value: String);
    var
      L: LongInt;
    begin
      L := Length(Value);
      WriteLongInt(Stream, L);
      Stream.Write(Value[1], L);
    end;
     
     
    { TCompany }
     
    constructor TCompany.Create(const AName: string; ARevenues: Currency;
    AEmployeeCount: Integer);
    begin
      FName := AName;
      FRevenues := ARevenues;
      FEmployeeCount := AEmployeeCount;
    end;
     
     
    procedure TCompany.LoadFromStream(Stream: TStream);
    begin
      FName := ReadString(Stream);
      FRevenues := ReadCurrency(Stream);
      FEmployeeCount := ReadLongInt(Stream);
    end;
     
     
    procedure TCompany.SaveToStream(Stream: TStream);
    begin
      WriteString(Stream, FName);
      WriteCurrency(Stream, FRevenues);
      WriteLongInt(Stream, FEmployeeCount);
    end;
     
     
    procedure TForm1.LoadButtonClick(Sender: TObject);
    var
      List: TStreamableList;
      Stream: TStream;
      Instance: TStreamableObject;
      I: Integer;
    begin
      Stream := TFileStream.Create(Path + DEFAULT_FILENAME, fmOpenRead);
      try
        List := TStreamableList.Create;
        try
          List.LoadFromStream(Stream);
          for I := 0 to List.Count - 1 do
          begin
            Instance := List[I];
            if Instance is TPerson then
              ShowMessage(TPerson(Instance).Name);
            if Instance is TCompany then
              ShowMessage(TCompany(Instance).Name);
          end;
        finally
          List.Free;
        end;
      finally
        Stream.Free;
      end;
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Path := ExtractFilePath(Application.ExeName);
    end;
     
    initialization
      RegisterClasses([TPerson, TCompany]);
     
    end.


------------------------------------------------------------------------

Вариант 2:

Author: Yoav (<Yoav@tsoft-tele.com>)

Source: <https://www.lmc-mediaagentur.de/dpool>

The solution above will work, but it forces you to implement streaming
support for each of the TStreamableObject objects. Delphi has already
implemented this mechanism in for the TPersistent class and the
TComponent class, and you can use this mechanism. The class I include
here does the job. It holds classes that inherit from TUmbCollectionItem
(which in turn inherits from Delphi TCollectionItem), and handles all
the streaming of the items. As the items are written with the Delphi
mechanism, all published data is streamed.

Notes: This class does not support working within the delphi IDE like
TCollection. All objects inheriting from TUmbCollectionItem must be
registered using the Classes.RegisterClass function. All objects
inheriting from TUmbCollectionItem must implement the assign function.
By default, the TUmbCollection owns its items (frees them when the
collection is freed), but this functionality can be changed.

    unit UmbCollection;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, contnrs;
     
     
    type
      TUmbCollectionItemClass = Class of TUmbCollectionItem;
      TUmbCollectionItem = class(TCollectionItem)
      private
        FPosition: Integer;
      public
        {when overriding this method, you must call the inherited assign.}
        procedure Assign(Source: TPersistent); Override;
      published
        {the position property is used by the streaming mechanism to place the object in the
        right position when reading the items. do not use this property.}
        property Position: Integer read FPosition write FPosition;
      end;
     
      TUmbCollection = class(TObjectList)
      private
        procedure SetItems(Index: Integer; Value: TUmbCollectionItem);
        function GetItems(Index: Integer): TUmbCollectionItem;
      public
        function Add(AObject: TUmbCollectionItem): Integer;
        function Remove(AObject: TUmbCollectionItem): Integer;
        function IndexOf(AObject: TUmbCollectionItem): Integer;
        function FindInstanceOf(AClass: TUmbCollectionItemClass; AExact: Boolean = True;
                                                      AStartAt: Integer = 0): Integer;
        procedure Insert(Index: Integer; AObject: TUmbCollectionItem);
     
        procedure WriteToStream(AStream: TStream); virtual;
        procedure ReadFromStream(AStream: TStream); virtual;
     
        property Items[Index: Integer]: TUmbCollectionItem read GetItems write SetItems; default;
      published
        property OwnsObjects;
      end;
     
    implementation
     
    { TUmbCollection }
     
    function ItemsCompare(Item1, Item2: Pointer): Integer;
    begin
      Result := TUmbCollectionItem(Item1).Position - TUmbCollectionItem(Item2).Position;
    end;
     
     
    function TUmbCollection.Add(AObject: TUmbCollectionItem): Integer;
    begin
      Result := inherited Add(AObject);
    end;
     
     
    function TUmbCollection.FindInstanceOf(AClass: TUmbCollectionItemClass;
    AExact: Boolean; AStartAt: Integer): Integer;
    begin
      Result := inherited FindInstanceOf(AClass, AExact, AStartAt);
    end;
     
     
    function TUmbCollection.GetItems(Index: Integer): TUmbCollectionItem;
    begin
      Result := inherited Items[Index] as TUmbCollectionItem;
    end;
     
     
    function TUmbCollection.IndexOf(AObject: TUmbCollectionItem): Integer;
    begin
      Result := inherited IndexOf(AObject);
    end;
     
     
    procedure TUmbCollection.Insert(Index: Integer; AObject: TUmbCollectionItem);
    begin
      inherited Insert(Index, AObject);
    end;
     
     
    procedure TUmbCollection.ReadFromStream(AStream: TStream);
    var
      Reader: TReader;
      Collection: TCollection;
      ItemClassName: string;
      ItemClass: TUmbCollectionItemClass;
      Item: TUmbCollectionItem;
      i: Integer;
    begin
      Clear;
      Reader := TReader.Create(AStream, 1024);
      try
        Reader.ReadListBegin;
        while not Reader.EndOfList do
        begin
          ItemClassName := Reader.ReadString;
          ItemClass := TUmbCollectionItemClass(FindClass(ItemClassName));
          Collection := TCollection.Create(ItemClass);
          try
            Reader.ReadValue;
            Reader.ReadCollection(Collection);
            for i := 0 to Collection.Count - 1 do
            begin
              item := ItemClass.Create(nil);
              item.Assign(Collection.Items[i]);
              Add(Item);
            end;
          finally
            Collection.Free;
          end;
        end;
        Sort(ItemsCompare);
        Reader.ReadListEnd;
      finally
        Reader.Free;
      end;
    end;
     
     
    function TUmbCollection.Remove(AObject: TUmbCollectionItem): Integer;
    begin
      Result := inherited Remove(AObject);
    end;
     
     
    procedure TUmbCollection.SetItems(Index: Integer; Value: TUmbCollectionItem);
    begin
      inherited Items[Index] := Value;
    end;
     
     
    procedure TUmbCollection.WriteToStream(AStream: TStream);
    var
      Writer: TWriter;
      CollectionList: TObjectList;
      Collection: TCollection;
      ItemClass: TUmbCollectionItemClass;
      ObjectWritten: array of Boolean;
      i, j: Integer;
    begin
      Writer := TWriter.Create(AStream, 1024);
      CollectionList := TObjectList.Create(True);
      try
        Writer.WriteListBegin;
        {init the flag array and the position property of the TCollectionItem objects.}
        SetLength(ObjectWritten, Count);
        for i := 0 to Count - 1 do
        begin
          ObjectWritten[i] := False;
          Items[i].Position := i;
        end;
        {write the TCollectionItem objects. we write first the name of the objects class,
        then write all the object of the same class.}
        for i := 0 to Count - 1 do
        begin
          if ObjectWritten[i] then
            Continue;
          ItemClass := TUmbCollectionItemClass(Items[i].ClassType);
          Collection := TCollection.Create(ItemClass);
          CollectionList.Add(Collection);
          {write the items class name}
          Writer.WriteString(Items[i].ClassName);
          {insert the items to the collection}
          for j := i to Count - 1 do
            if ItemClass = Items[j].ClassType then
            begin
              ObjectWritten[j] := True;
              (Collection.Add as ItemClass).Assign(Items[j]);
            end;
          {write the collection}
          Writer.WriteCollection(Collection);
        end;
      finally
        CollectionList.Free;
        Writer.WriteListEnd;
        Writer.Free;
      end;
    end;
     
     
    { TUmbCollectionItem }
     
    procedure TUmbCollectionItem.Assign(Source: TPersistent);
    begin
      if Source is TUmbCollectionItem then
        Position := (Source as TUmbCollectionItem).Position
      else
        inherited;
    end;
     
    end.

