package com.example.carspy;

import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.Toast;
import android.app.ActionBar;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Color;

public class RegisterUser extends Activity implements OnClickListener {
	boolean startUp = false;
	Button btnRegister;
	Button btnCancel;
	Button btnUserInfo;
	Button btnVehicleInfo;
	ImageView imgButtonUserInfo;
	ImageView imgButtonVehicleInfo;
	TableLayout tblUserText;
	TableLayout tblVehicleText;
	TableLayout tblUserTextBoxes;
	TableLayout tblVehicleTextBoxes;
	EditText txbFName;
	EditText txbLName;
	EditText txbEmail;
	EditText txbGender;
	EditText txbBDay;
	EditText txbPhone;
	EditText txbAddress;
	EditText txbPassword;
	EditText txbDeviceID;
	EditText txbMake;
	EditText txbModel;
	EditText txbYear;
	EditText txbColor;
	EditText txbLicensePlate;
	

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.register_user);

		ActionBar actionBar = getActionBar();
		actionBar.hide();		
		
		initializeVisualComponents();
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnCancel) {
			Intent loginActivity = new Intent(RegisterUser.this, Login.class);
			startActivity(loginActivity);
		}
		else if (v.getId() == R.id.btnRegister) {
			//TODO: Verify Device ID is correct.
			//TODO: Update information in DB.
			Toast.makeText(this, "New user has been registered..", Toast.LENGTH_LONG).show();
			Intent mainActivity = new Intent(RegisterUser.this, Main.class);
			startActivity(mainActivity);
		}
		else if (v.getId() == R.id.btnUserInfo) {
			btnUserInfo.setTextColor(Color.BLACK);
			btnVehicleInfo.setTextColor(Color.GRAY);
			imgButtonVehicleInfo.setVisibility(View.INVISIBLE);
			imgButtonUserInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.VISIBLE);
			tblVehicleText.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
		}
		else if (v.getId() == R.id.btnVehicleInfo) {
			btnVehicleInfo.setTextColor(Color.BLACK);
			btnUserInfo.setTextColor(Color.GRAY);
			imgButtonUserInfo.setVisibility(View.INVISIBLE);
			imgButtonVehicleInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.INVISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			tblVehicleText.setVisibility(View.VISIBLE);
			tblVehicleTextBoxes.setVisibility(View.VISIBLE);
		}
	}

	private void initializeVisualComponents() {
		btnRegister = (Button) findViewById(R.id.btnRegister);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);

		imgButtonUserInfo = (ImageView) findViewById(R.id.imgButtonUserInfo);
		imgButtonVehicleInfo = (ImageView) findViewById(R.id.imgButtonVehicleInfo);

		tblUserText = (TableLayout) findViewById(R.id.tblUserText);
		tblVehicleText = (TableLayout) findViewById(R.id.tblVehicleText);
		tblUserTextBoxes = (TableLayout) findViewById(R.id.tblUserTextBoxes);
		tblVehicleTextBoxes = (TableLayout) findViewById(R.id.tblVehicleTextBoxes);

		txbFName = (EditText) findViewById(R.id.txbFName);
		txbLName = (EditText) findViewById(R.id.txbLName);
		txbEmail = (EditText) findViewById(R.id.txbEmail);
		txbGender = (EditText) findViewById(R.id.txbGender);
		txbBDay = (EditText) findViewById(R.id.txbBDay);
		txbPhone = (EditText) findViewById(R.id.txbPhone);
		txbAddress = (EditText) findViewById(R.id.txbAddress);
		txbPassword = (EditText) findViewById(R.id.txbPassword);

		txbDeviceID = (EditText) findViewById(R.id.txbDeviceID);
		txbMake = (EditText) findViewById(R.id.txbMake);
		txbModel = (EditText) findViewById(R.id.txbModel);
		txbYear = (EditText) findViewById(R.id.txbYear);
		txbColor = (EditText) findViewById(R.id.txbColor);
		txbLicensePlate = (EditText) findViewById(R.id.txbLicensePlate);

		btnRegister.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
	}
}
