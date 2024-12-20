---
Title: Экспортировать ветвь реестра
Author: Arthur Hoornweg (arthur.hoornweg@email.de) 
Date: 26.05.1998 
Source: <https://www.swissdelphicenter.ch>
---

Экспортировать ветвь реестра
============================

    unit RegExpo;
     
    interface
    
    uses
      Windows, rRegistry, Classes, SysUtils;
    
    {$I-}
    {$LONGSTRINGS ON}
    
    { 
     Regexpo 
    
     Author : Arthur Hoornweg (arthur.hoornweg@email.de) 
     Version : 1.00, May 1998 
     O/S : Windows 95, 98, ME, NT, 2000, XP 
           Delphi 2+ 
     Function : 
       This unit allows you to backup a branch of the registry into a *.REG file, 
       that is compatible with "regedit". 
       Double-clicking such a file in the explorer will import it. 
    
    
     Example: 
       ExportRegistryBranch(HKEY_LOCAL_MACHINE,'SOFTWARE\Borland\Delphi','A:\DELPHI.REG') 
    
     (c) 1998 A.M. Hoornweg. All rights reserved. 
    
     You may use this software for all purposes, both commercial and 
     noncommercial, as long as proper credit is given. The sourcecode may be distributed 
     freely, as long as this copyright is included and no more than a marginal fee is 
     asked. 
    
    
     Disclaimer: 
    
     I accept no responsibility whatsoever for any damages caused by these 
     routines. Use them at your own risk. If you find any bugs, please let me know. 
    }
    
    
    procedure ExportRegistryBranch(Rootsection: Integer; regroot: string;
      FileName: string);
    
    implementation
    
    function dblBackSlash(t: string): string;
    var
      k: longint;
    begin
      Result := t; {Strings are not allowed to have}
      for k := Length(t) downto 1 do {single backslashes}
        if Result[k] = '\' then Insert('\', Result, k);
    end;
    
    
    procedure ExportRegistryBranch(rootsection: Integer; Regroot: string;
      FileName: string);
    var
      reg: TRegistry;
      f: Textfile;
      p: PChar;
    
      procedure ProcessBranch(root: string); {recursive sub-procedure}
      var
        values, keys: TStringList;
        i, j, k: longint;
        s, t: string; {longstrings are on the heap, not on the stack!}
      begin
        Writeln(f); {write blank line}
        case rootsection of
          HKEY_CLASSES_ROOT: s   := 'HKEY_CLASSES_ROOT';
          HKEY_CURRENT_USER: s   := 'HKEY_CURRENT_USER';
          HKEY_LOCAL_MACHINE: s  := 'HKEY_LOCAL_MACHINE';
          HKEY_USERS: s          := 'HKEY_USERS';
          HKEY_PERFORMANCE_DATA: s := 'HKEY_PERFORMANCE_DATA';
          HKEY_CURRENT_CONFIG: s := 'HKEY_CURRENT_CONFIG';
          HKEY_DYN_DATA: s       := 'HKEY_DYN_DATA';
        end;
        Writeln(f, '[' + s + '\' + root + ']'); {write section name in brackets}
    
        reg.OpenKey(root, False);
        try
          values := TStringList.Create;
          try
            keys := TStringList.Create;
            try
              reg.GetValuenames(values); {get all value names}
              reg.GetKeynames(keys); {get all sub-branches}
    
              for i := 0 to values.Count - 1 do {write all the values first}
              begin
                s := values[i];
                t := s; {s=value name}
                if s = '' then s := '@' {empty means "default value", write as @}
                else
                  s := '"' + s + '"'; {else put in quotes}
                Write(f, dblbackslash(s) + '='); {write the name of the key to the file}
    
                case reg.Getdatatype(t) of {What type of data is it?}
    
                  rdString, rdExpandString: {String-type}
                    Writeln(f, '"' + dblbackslash(reg.ReadString(t) + '"'));
    
                  rdInteger: {32-bit unsigned long integer}
                    Writeln(f, 'dword:' + IntToHex(reg.readinteger(t), 8));
    
                 {write an array of hex bytes if data is "binary." Perform a line feed 
                 after approx. 25 numbers so the line length stays within limits}
    
                  rdBinary:
                    begin
                      Write(f, 'hex:');
                      j := reg.GetDataSize(t); {determine size}
                      GetMem(p, j); {Allocate memory}
                      reg.ReadBinaryData(t, p^, J); {read in the data, treat as pchar}
                      for k := 0 to j - 1 do
                      begin
                        Write(f, IntToHex(Byte(p[k]), 2)); {Write byte as hex}
                        if k <> j - 1 then {not yet last byte?}
                        begin
                          Write(f, ','); {then write Comma}
                          if (k > 0) and ((k mod 25) = 0) {line too long?} then
                            Writeln(f, '\'); {then write Backslash +lf}
                        end; {if}
                      end; {for}
                      FreeMem(p, j); {free the memory}
                      Writeln(f); {Linefeed}
                    end;
                  else
                    Writeln(f, '""'); {write an empty string if datatype illegal/unknown}
                end;{case}
              end; {for}
            finally
              reg.CloseKey;
            end;
    
          finally
            {value names all done, no longer needed}
            values.Free;
          end;
    
          {Now al values are written, we process all subkeys}
          {Perform this process RECURSIVELY...}
          for i := 0 to keys.Count - 1 do
            ProcessBranch(root + '\' + keys[i]);
        finally
          keys.Free; {this branch is ready}
        end;
      end; { ProcessBranch}
    
    
    begin
      if RegRoot[Length(Regroot)] = '\' then {No trailing backslash}
        SetLength(regroot, Length(Regroot) - 1);
      Assignfile(f, FileName); {create a text file}
      Rewrite(f);
      if ioResult <> 0 then Exit;
      Writeln(f, 'REGEDIT4'); {"magic key" for regedit}
    
      reg := TRegistry.Create;
      try
        reg.Rootkey := Rootsection;
        {Call the function that writes the branch and all subbranches}
        ProcessBranch(Regroot);
      finally
        reg.Free; {ready}
        Close(f);
      end;
    end;
    
    end.

