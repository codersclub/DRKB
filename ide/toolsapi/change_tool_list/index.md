---
Title: Програмно меняем Delphi Tool List
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Програмно меняем Delphi Tool List
====================================

    //**  class to manage Delphi's Tool list
    //**
    //**  if Delphi is running restart it to see changes
    //*************************************************************
     
    unit DelphiTool;
     
    interface
     
    uses
      Windows, SysUtils, Registry, classes;
     
    type
      TDelphiVersion = ({dvD5,} dvD6);
     
      EDelphiTool_AlreadyRegistered = class(Exception);
      EDelphiTool_InvalidIndex = class(Exception);
     
      TDelphiTool = class
      private
        F_Registry: TRegistry;
        F_ToolCount: Integer;
        F_ToolPath: string;
      protected
        function OpenKey(key: string; CanCreate: Boolean): Boolean;
     
      public
        constructor Create;
        destructor Destroy; override;
     
        procedure SetRootKey(root_key: HKEY);
        procedure SetDelphiVersion(version: TDelphiVersion);
     
        procedure Add(params, path, title, workingDir: string);
        procedure Edit(toolIndex: Integer; params, path, title, workingDir: string);
        procedure Delete(toolIndex: Integer);
     
        function IndexOf(toolTitle: string): Integer;
        function Count: Integer;
        procedure ToolProperties(toolIndex: Integer;
          out params, path, title, workingDir: string);
      end;
     
     
    implementation
     
    { TDelphiTool }
     
    constructor TDelphiTool.Create;
    begin
      inherited;
      SetDelphiVersion(dvD6);
      F_Registry := TRegistry.Create;
    end;
     
    destructor TDelphiTool.Destroy;
    begin
      F_Registry.CloseKey;
      F_Registry.Free;
      inherited;
    end;
     
    function TDelphiTool.IndexOf(toolTitle: string): Integer;
    var
      found: boolean;
      loop: integer;
      Count: integer;
    begin
      Result := -1;
     
      if OpenKey(F_ToolPath, True) then
      begin
        loop  := 0;
        found := False;
        while (loop < F_ToolCount) and not found do
        begin
          found := F_Registry.ReadString('Title' + IntToStr(loop)) = toolTitle;
          if not found then Inc(loop);
        end;
      end;
     
      if found then Result := loop;
    end;
     
    procedure TDelphiTool.SetRootKey(root_key: HKEY);
    begin
      F_Registry.RootKey := root_key;
    end;
     
    procedure TDelphiTool.Add(params, path, title, workingDir: string);
    var
      Count: integer;
      suffix: string;
    begin
      if OpenKey(F_ToolPath, True) then
      begin
        try
          if IndexOf(title) < 0 then
          begin
            Count  := F_ToolCount;
            suffix := IntToStr(Count);
            Inc(Count);
     
            F_registry.WriteString('Params' + suffix, params);
            F_registry.WriteString('Path' + suffix, path);
            F_registry.WriteString('Title' + suffix, title);
            F_registry.WriteString('WorkingDir' + suffix, workingDir);
     
            F_registry.WriteInteger('Count', Count);
            F_ToolCount := Count;
          end
          else
            raise EDelphiTool_AlreadyRegistered.Create('[Add]: Tool is already registered.');
        finally
          F_Registry.CloseKey;
        end;
      end
    end;
     
    function TDelphiTool.OpenKey(key: string; CanCreate: Boolean): Boolean;
    begin
      Result := F_Registry.OpenKey(key, CanCreate);
      if F_Registry.ValueExists('Count') then F_ToolCount := F_Registry.ReadInteger('Count')
      else
        F_ToolCount := 0;
    end;
     
    procedure TDelphiTool.Edit(toolIndex: Integer; params, path, title, 
              workingDir: string);
      // if you don't want to change one property set to ''
    var
      suffix: string;
    begin
      if (toolIndex < 0) or (toolIndex >= F_ToolCount) then
        raise EDelphiTool_InvalidIndex.Create('[Edit]: Invalid index.')
      else
      begin
        if OpenKey(F_ToolPath, True) then
        begin
          try
            suffix := IntToStr(toolIndex);
     
            if (params <> '') then
              F_registry.WriteString('Params' + suffix, params);
            if (path <> '') then
              F_registry.WriteString('Path' + suffix, path);
            if (title <> '') then
              F_registry.WriteString('Title' + suffix, title);
            if (workingDir <> '') then
              F_registry.WriteString('WorkingDir' + suffix, workingDir);
     
          finally
            F_Registry.CloseKey;
          end;
        end
      end;
    end;
     
    procedure TDelphiTool.Delete(toolIndex: Integer);
    var
      suffix, tmp_suffix: string;
      i: integer;
    begin
      if (toolIndex < 0) or (toolIndex >= F_ToolCount) then
        raise EDelphiTool_InvalidIndex.Create('[Delete]: Invalid index.')
      else
      begin
        if OpenKey(F_ToolPath, True) then
        begin
          try
            suffix := IntToStr(toolIndex);
            for i := toolIndex + 1 to F_ToolCount - 1 do
            begin
              tmp_suffix := IntToStr(i);
              F_registry.WriteString('Params' + suffix,
                F_registry.ReadString('Params' + tmp_suffix));
              F_registry.WriteString('Path' + suffix,
                F_registry.ReadString('Path' + tmp_suffix));
              F_registry.WriteString('Title' + suffix,
                F_registry.ReadString('Title' + tmp_suffix));
              F_registry.WriteString('WorkingDir' + suffix,
                F_registry.ReadString('WorkingDir' + tmp_suffix));
     
              suffix := IntToStr(i);
            end;
     
            F_registry.DeleteValue('Params' + suffix);
            F_registry.DeleteValue('Path' + suffix);
            F_registry.DeleteValue('Title' + suffix);
            F_registry.DeleteValue('WorkingDir' + suffix);
     
            F_registry.WriteInteger('Count', F_ToolCount - 1);
            Dec(F_ToolCount);
          finally
            F_Registry.CloseKey;
          end;
        end;
      end;
    end;
     
    procedure TDelphiTool.SetDelphiVersion(version: TDelphiVersion);
      //*************************************************************
      //  for versions other then D6 lookup the registry and add lines
      // like below, also add dvDx entries to TDelphiVersion
    begin
      case version of
        dvD6: F_ToolPath := '\Software\Borland\Delphi\6.0\Transfer';
     
        //** don't have D5, just guessing, so check it in the registry
        //** before uncommenting
        //   dvD5: F_ToolPath:= '\Software\Borland\Delphi\5.0\Transfer';
      end;
    end;
     
    function TDelphiTool.Count: Integer;
    begin
      Result := F_ToolCount;
    end;
     
    procedure TDelphiTool.ToolProperties(toolIndex: Integer; out params, path,
      title, workingDir: string);
    var
      suffix: string;
    begin
      if (toolIndex < 0) or (toolIndex >= F_ToolCount) then
        raise EDelphiTool_InvalidIndex.Create('[ToolProperties]: Invalid index.')
      else
      begin
        if OpenKey(F_ToolPath, True) then
        begin
          try
            suffix := IntToStr(toolIndex);
     
            params := F_registry.ReadString('Params' + suffix);
            path := F_registry.ReadString('Path' + suffix);
            title := F_registry.ReadString('Title' + suffix);
            workingDir := F_registry.ReadString('WorkingDir' + suffix);
     
          finally
            F_Registry.CloseKey;
          end;
        end
      end;
    end;
     
    end.
     
    //*******************************************************************
    //**  how to use it?
    //*******************************************************************
    unit Unit1;
     
    interface
     
    uses
      Windows, {...}, DelphiTool;
     
     //...
     //...
     //...
     
    var
      Form1: TForm1;
     
    implementation
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      with TDelphiTool.Create do
        try
          //  Delete(IndexOf('MyTool'));
          Add('', Application.ExeName, 'MyTool', ExtractFilePath(Application.ExeName));
          //  Edit(IndexOf('MyTool'), '', '', 'MyTool But Edited', '');
        finally
          Free;
        end;
    end;


