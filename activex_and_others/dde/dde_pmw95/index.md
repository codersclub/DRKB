---
Title: Управление Program Manager в Win95 с помощью DDE
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Управление Program Manager в Win95 с помощью DDE
================================================

Для управления программными группами в Program Manager с помощью DDE
мною был использован следующий модуль. За основу был взят код Steve
Texeira (sp) из руководства Dephi Developers Guide.

Работает под Win 3.1 и \'95.

    unit Pm;
     
    interface
     
    uses
      SysUtils, Classes, DdeMan;
     
    type
      EProgManError = class(Exception);
     
      TProgMan = class(TComponent)
      private
        FDdeClientConv: TDdeClientConv;
        procedure InitDDEConversation;
        function ExecMacroString(Macro: string): Boolean;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure CreateGroup(GroupName: string; ShowGroup: Boolean);
        procedure DeleteGroup(GroupName: string);
        procedure DeleteItem(ItemName: string);
        procedure AddItem(CmdLine, ItemName: string);
      end;
     
    implementation
     
    uses Utils;
     
    const
     
      { DDE-макростроки для Program Manager }
      SDDECreateGroup = '[CreateGroup(%s)]';
      SDDEShowGroup = '[ShowGroup(%s, 1)]';
      SDDEDeleteGroup = '[DeleteGroup(%s)]';
      SDDEDeleteItem = '[DeleteItem(%s)]';
      SDDEAddItem = '[AddItem(%s, "%s", %s)]';
     
    constructor TProgMan.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      InitDDEConversation;
    end;
     
    destructor TProgMan.Destroy;
    begin
     
      if Assigned(FDDEClientConv) then
        FDdeClientConv.CloseLink;
      inherited Destroy;
    end;
     
    function TProgMan.ExecMacroString(Macro: string): Boolean;
    begin
     
      StringAsPchar(Macro);
      Result := FDdeClientConv.ExecuteMacro(@Macro[1], False);
    end;
     
    procedure TProgMan.InitDDEConversation;
    begin
     
      FDdeClientConv := TDdeClientConv.Create(Self);
      if not FDdeClientConv.SetLink('PROGMAN', 'PROGMAN') then
        raise EProgManError.Create('Не могу установить DDE Link');
    end;
     
    procedure TProgMan.CreateGroup(GroupName: string; ShowGroup: Boolean);
    begin
     
      { Удаляем группу, если она существует }
      ExecMacroString(Format(SDDEDeleteGroup, [GroupName]));
     
      if not ExecMacroString(Format(SDDECreateGroup, [GroupName])) then
        raise EProgManError.Create('Не могу создать группу ' + GroupName);
      if ShowGroup then
        if not ExecMacroString(Format(SDDEShowGroup, [GroupName])) then
          raise EProgManError.Create('Не могу показать группу ' + GroupName);
    end;
     
    procedure TProgMan.DeleteGroup(GroupName: string);
    begin
     
      if not ExecMacroString(Format(SDDEDeleteGroup, [GroupName])) then
        raise EProgManError.Create('Не могу удалить группу ' + GroupName);
    end;
     
    procedure TProgMan.DeleteItem(ItemName: string);
    begin
     
      if not ExecMacroString(Format(SDDEDeleteGroup, [ItemName])) then
        raise EProgManError.Create('Не могу удалить элемент ' + ItemName);
    end;
     
    procedure TProgMan.AddItem(CmdLine, ItemName: string);
    var
     
      P: PChar;
      PSize: Word;
    begin
     
      PSize := StrLen(SDDEAddItem) + (Length(CmdLine) * 2) + Length(ItemName) + 1;
      GetMem(P, PSize);
      try
        StrFmt(P, SDDEAddItem, [CmdLine, ItemName, CmdLine]);
        if not FDdeClientConv.ExecuteMacro(P, False) then
          raise EProgManError.Create('Не могу добавить элемент ' + ItemName);
      finally
        FreeMem(P, PSize);
      end;
    end;
     
    end.
