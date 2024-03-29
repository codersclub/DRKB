---
Title: Быстрый доступ к ADO
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Быстрый доступ к ADO
====================

    unit ADO;
    {This unit provides a quick access into ADO
          It handles all it's own exceptions
          It assumes it is working with SQL Server, on a PLC Database
             If an exception is thrown with a [PLCErr] suffix:
                   the suffix is removed, and ErrMsg is set to the remaining string
                 otherwise
                   the whole exception is reported in ErrMsg
                 Either way, the function call fails.
     
          Globals: adocn     - connection which all other ADO objects use
                   adors     - Recordset
                   adocmd    - Command Object
                   adocmdprm - Command Object set aside for Parametric querying
                   ConnectionString
                             - Connection String used for connecting
     
                   ErrMsg    - Last Error Message
                   ADOActive - Indicator as to whether ADO has been started yet
     
    Functions:
    General ADO
               ADOStart:Boolean;
               ADOReset:Boolean;
               ADOStop:Boolean;
     
    Recordsets
               RSOpen(SQL:string;adRSType,adLockType,adCmdType:integer;UseServer:Boolean):Boolean;
               RSClose:Boolean;
     
    Normal Command Procedures
               CMDExec(SQL:string;adCmdType:integer):Boolean;
     
    Parametric Procedures
               PRMClear:Boolean;
               PRMSetSP(StoredProcedure:string;WithClear:Boolean):Boolean;
               PRMAdd(ParamName:string;ParamType,ParamIO,ParamSize:integer;Val:variant):Boolean;
               PRMSetParamVal(ParamName:string;val:variant):Boolean;
               PRMGetParamVal(ParamName:string;var val:variant):Boolean;
     
    Field Operations
               function SQLStr(str:string;SQLStrType:TSQLStrType);
               function SentenceCase(str:string):string;
     
               --to convert from 'FIELD_NAME' -> 'Field Name' call
               SQLStr(SentenceCase(txt),ssFromSQL);
    }
     
    interface
     
    uses OLEAuto, sysutils;
     
    const
      {Param Data Types}
      adInteger = 3;
      adSingle = 4;
      adDate = 7;
      adBoolean = 11;
      adTinyInt = 16;
      adUnsignedTinyInt = 17;
      adDateTime = 135;
      advarChar = 200;
     
      {Param Directions}
      adParamInput = 1;
      adParamOutput = 2;
      adParamReturnValue = 4;
     
      {Command Types}
      adCmdText = 1;
      adCmdTable = 2;
      adCmdStoredProc = 4;
      adCmdTableDirect = 512;
      adCmdFile = 256;
     
      {Cursor/RS Types}
      adOpenForwardOnly = 0;
      adOpenKeyset = 1;
      adOpenDynamic = 2;
      adOpenStatic = 3;
     
      {Lock Types}
      adLockReadOnly = 1;
      adLockOptimistic = 3;
     
      {Cursor Locations}
      adUseServer = 2;
      adUseClient = 3;
     
    function ADOReset: Boolean;
    function ADOStop: Boolean;
     
    function RSOpen(SQL: string; adRSType, adLockType, adCmdType: integer;
      UseServer: Boolean): Boolean;
    function RSClose: Boolean;
     
    function CMDExec(SQL: string; adCmdType: integer): Boolean;
     
    function PRMClear: Boolean;
    function PRMSetSP(StoredProcedure: string; WithClear: Boolean): Boolean;
    function PRMAdd(ParamName: string; ParamType, ParamIO, ParamSize: integer; Val:
      variant): Boolean;
    function PRMSetParamVal(ParamName: string; val: variant): Boolean;
    function PRMGetParamVal(ParamName: string; var val: variant): Boolean;
     
    type
      TSQLStrType = (ssToSQL, ssFromSQL);
    function SQLStr(str: string; SQLStrType: TSQLStrType): string;
    function SentenceCase(str: string): string;
     
    var
      adocn, adors, adocmd, adocmdPrm: variant;
      ConnectionString, ErrMsg: string;
      ADOActive: boolean = false;
     
    implementation
     
    var
      UsingConnection: Boolean;
     
    function ADOStart: Boolean;
    begin
      //Get the Object References
      try
        adocn := CreateOLEObject('ADODB.Connection');
        adors := CreateOLEObject('ADODB.Recordset');
        adocmd := CreateOLEObject('ADODB.Command');
        adocmdprm := CreateOLEObject('ADODB.Command');
        result := true;
      except
        on E: Exception do
        begin
          ErrMsg := e.message;
          Result := false;
        end;
      end;
      ADOActive := result;
    end;
     
    function ADOReset: Boolean;
    begin
      Result := false;
      //Ensure a clean slate...
      if not (ADOStop) then
        exit;
     
      //Restart all the ADO References
      if not (ADOStart) then
        exit;
     
      //Wire up the Connections
      //If the ADOconnetion fails, all objects will use the connection string
      //                               directly - poorer performance, but it works!!
      try
        adocn.ConnectionString := ConnectionString;
        adocn.open;
        adors.activeconnection := adocn;
        adocmd.activeconnection := adocn;
        adocmdprm.activeconnection := adocn;
        UsingConnection := true;
      except
        try
          adocn := unassigned;
          UsingConnection := false;
          adocmd.activeconnection := ConnectionString;
          adocmdprm.activeconnection := ConnectionString;
        except
          on e: exception do
          begin
            ErrMsg := e.message;
            exit;
          end;
        end;
      end;
      Result := true;
    end;
     
    function ADOStop: Boolean;
    begin
      try
        if not (varisempty(adocn)) then
        begin
          adocn.close;
          adocn := unassigned;
        end;
        adors := unassigned;
        adocmd := unassigned;
        adocmdprm := unassigned;
        result := true;
      except
        on E: Exception do
        begin
          ErrMsg := e.message;
          Result := false;
        end;
      end;
      ADOActive := false;
    end;
     
    function RSOpen(SQL: string; adRSType, adLockType, adCmdType: integer;
      UseServer: Boolean): Boolean;
    begin
      result := false;
      //Have two attempts at getting the required Recordset
      if UsingConnection then
      begin
        try
          if UseServer then
            adors.CursorLocation := adUseServer
          else
            adors.CursorLocation := adUseClient;
          adors.open(SQL,, adRSType, adLockType, adCmdType);
        except
          if not (ADOReset) then
            exit;
          try
            if UseServer then
              adors.CursorLocation := adUseServer
            else
              adors.CursorLocation := adUseClient;
            adors.open(SQL,, adRSType, adLockType, adCmdType);
          except
            on E: Exception do
            begin
              ErrMsg := e.message;
              exit;
            end;
          end;
        end;
      end
      else
      begin
        //Use the Connetcion String to establish a link
        try
          adors.open(SQL, ConnectionString, adRSType, adLockType, adCmdType);
        except
          if not (ADOReset) then
            exit;
          try
            adors.open(SQL, ConnectionString, adRSType, adLockType, adCmdType);
          except
            on E: Exception do
            begin
              ErrMsg := e.message;
              exit;
            end;
          end;
        end;
      end;
      Result := true;
    end;
     
    function RSClose: Boolean;
    begin
      try
        adors.Close;
        result := true;
      except
        on E: Exception do
        begin
          ErrMsg := e.message;
          result := false;
        end;
      end;
    end;
     
    function CMDExec(SQL: string; adCmdType: integer): Boolean;
    begin
      result := false;
      //Have two attempts at the execution..
      try
        adocmd.commandtext := SQL;
        adocmd.commandtype := adCmdType;
        adocmd.execute;
      except
        try
          if not (ADOReset) then
            exit;
          adocmd.commandtext := SQL;
          adocmd.commandtype := adCmdType;
          adocmd.execute;
        except
          on e: exception do
          begin
            ErrMsg := e.message;
            exit;
          end;
        end;
      end;
      result := true;
    end;
     
    function PRMClear: Boolean;
    var
      i: integer;
    begin
      try
        for i := 0 to (adocmdprm.parameters.count) - 1 do
        begin
          adocmdprm.parameters.delete(0);
        end;
        result := true;
      except
        on e: exception do
        begin
          ErrMsg := e.message;
          result := false;
        end;
      end;
    end;
     
    function PRMSetSP(StoredProcedure: string; WithClear: Boolean): Boolean;
    begin
      result := false;
      //Have two attempts at setting the Stored Procedure...
      try
        adocmdprm.commandtype := adcmdStoredProc;
        adocmdprm.commandtext := StoredProcedure;
        if WithClear then
          if not (PRMClear) then
            exit;
        result := true;
      except
        try
          if not (ADOReset) then
            exit;
          adocmdprm.commandtype := adcmdStoredProc;
          adocmdprm.commandtext := StoredProcedure;
          //NB: No need to clear the parameters, as an ADOReset will have done this..
          result := true;
        except
          on e: exception do
          begin
            ErrMsg := e.message;
          end;
        end;
      end;
    end;
     
    function PRMAdd(ParamName: string; ParamType, ParamIO, ParamSize: integer; Val:
      variant): Boolean;
    var
      DerivedParamSize: integer;
    begin
      //Only try once to add the parameter (a call to ADOReset would reset EVERYTHING!!)
      try
        case ParamType of
          adInteger: DerivedParamSize := 4;
          adSingle: DerivedParamSize := 4;
          adDate: DerivedParamSize := 8;
          adBoolean: DerivedParamSize := 1;
          adTinyInt: DerivedParamSize := 1;
          adUnsignedTinyInt: DerivedParamSize := 1;
          adDateTime: DerivedParamSize := 8;
          advarChar: DerivedParamSize := ParamSize;
        end;
        adocmdprm.parameters.append(adoCmdPrm.createparameter(ParamName, ParamType,
          ParamIO, DerivedParamSize, Val));
      except
        on e: exception do
        begin
          ErrMsg := e.message;
        end;
      end;
    end;
     
    function PRMSetParamVal(ParamName: string; val: variant): Boolean;
    begin
      //Only try once to set the parameter (a call to ADOReset would reset EVERYTHING!!)
      try
        adocmdprm.Parameters[ParamName].Value := val;
        result := true;
      except
        on e: exception do
        begin
          ErrMsg := e.message;
          result := false;
        end;
      end;
    end;
     
    function PRMGetParamVal(ParamName: string; var val: variant): Boolean;
    begin
      //Only try once to read the parameter (a call to ADOReset would reset EVERYTHING!!)
      try
        val := adocmdprm.Parameters[ParamName].Value;
        result := true;
      except
        on e: exception do
        begin
          ErrMsg := e.message;
          result := false;
        end;
      end;
    end;
     
    function SQLStr(str: string; SQLStrType: TSQLStrType): string;
    var
      FindChar, ReplaceChar: char;
    begin
      {Convert ' '->'_' for ssToSQL (remove spaces)
      Convert '_'->' ' for ssFromSQL (remove underscores)}
      case SQLStrType of
        ssToSQL:
          begin
            FindChar := ' ';
            ReplaceChar := '_';
          end;
        ssFromSQL:
          begin
            FindChar := '_';
            ReplaceChar := ' ';
          end;
      end;
     
      result := str;
      while Pos(FindChar, result) > 0 do
        Result[Pos(FindChar, result)] := ReplaceChar;
    end;
     
    function SentenceCase(str: string): string;
    var
      tmp: char;
      i {,len}: integer;
      NewWord: boolean;
    begin
      NewWord := true;
      result := str;
      for i := 1 to Length(str) do
      begin
        if (result[i] = ' ') or (result[i] = '_') then
          NewWord := true
        else
        begin
          tmp := result[i];
          if NewWord then
          begin
            NewWord := false;
            result[i] := chr(ord(result[i]) or 64); //Set bit 6 - makes uppercase
          end
          else
            result[i] := chr(ord(result[i]) and 191); //reset bit 6 - makes lowercase
        end;
      end;
      {This was the original way of doing it, but I wanted to look for spaces or '_'s,
            and it all seemed problematic - if I find a better way another day, I'll alter the above...
           if str<>'' then
              begin
                   tmp:=LowerCase(str);
                   len:=length(tmp);
                   tmp:=Uppercase(copy(tmp,1,1))+copy(tmp,2,len);
                   i:=pos('_',tmp);
                   while i<>0 do
                         begin
                              tmp:=copy(tmp,1,i-1)+' '+Uppercase(copy(tmp,i+1,1))+copy(tmp,i+2,len-i);
                              i:=pos('_',tmp);
                         end;
              end;
           result:=tmp;}
    end;
     
    end.

