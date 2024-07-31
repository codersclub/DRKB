---
Title: Как выключить master volume в звуковой карте?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как выключить master volume в звуковой карте?
=============================================

    uses
      MMSystem;
     
    function GetMasterMute(
      Mixer: hMixerObj;
      var Control: TMixerControl): MMResult;
      // Returns True on success
    var
      Line: TMixerLine;
      Controls: TMixerLineControls;
    begin
      ZeroMemory(@Line, SizeOf(Line));
      Line.cbStruct := SizeOf(Line);
      Line.dwComponentType := MIXERLINE_COMPONENTTYPE_DST_SPEAKERS;
      Result := mixerGetLineInfo(Mixer, @Line,
        MIXER_GETLINEINFOF_COMPONENTTYPE);
      if Result = MMSYSERR_NOERROR then
      begin
        ZeroMemory(@Controls, SizeOf(Controls));
        Controls.cbStruct := SizeOf(Controls);
        Controls.dwLineID := Line.dwLineID;
        Controls.cControls := 1;
        Controls.dwControlType := MIXERCONTROL_CONTROLTYPE_MUTE;
        Controls.cbmxctrl := SizeOf(Control);
        Controls.pamxctrl := @Control;
        Result := mixerGetLineControls(Mixer, @Controls,
          MIXER_GETLINECONTROLSF_ONEBYTYPE);
      end;
    end;
     
    procedure SetMasterMuteValue(
      Mixer: hMixerObj;
      Value: Boolean);
    var
      MasterMute: TMixerControl;
      Details: TMixerControlDetails;
      BoolDetails: TMixerControlDetailsBoolean;
      Code: MMResult;
    begin
      Code := GetMasterMute(0, MasterMute);
      if Code = MMSYSERR_NOERROR then
      begin
        with Details do
        begin
          cbStruct := SizeOf(Details);
          dwControlID := MasterMute.dwControlID;
          cChannels := 1;
          cMultipleItems := 0;
          cbDetails := SizeOf(BoolDetails);
          paDetails := @BoolDetails;
        end;
        LongBool(BoolDetails.fValue) := Value;
        Code := mixerSetControlDetails(0, @Details, MIXER_SETCONTROLDETAILSF_VALUE);
      end;
      if Code <> MMSYSERR_NOERROR then
        raise Exception.CreateFmt('SetMasterMuteValue failure, '+
          'multimedia system error #%d', [Code]);
    end;
     
    // Example:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SetMasterMuteValue(0, CheckBox1.Checked); // Mixer device #0 mute on/off
    end;

