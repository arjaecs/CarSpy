package com.example.carspy;

import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.TableLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.app.ActionBar;
import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;

public class Profile extends Activity implements OnItemSelectedListener, OnClickListener {
	boolean startUp = false;
	Button btnSave;
	Button btnCancel;
	Button btnEditInfo;
	Button btnUserInfo;
	Button btnVehicleInfo;
	Button btnAddNewVehicle;
	ImageButton btnLeftArrow;
	ImageButton btnRightArrow;
	ImageView imgButtonDouble;
	ImageView imgButtonUserInfo;
	ImageView imgButtonVehicleInfo;
	TableLayout tblUserText;
	TableLayout tblUserInfo;
	TableLayout tblVehicleText;
	TableLayout tblVehicleInfo;
	TableLayout tblUserTextBoxes;
	TableLayout tblVehicleTextBoxes;
	TextView txtFName;
	TextView txtLName;
	TextView txtEmail;
	TextView txtGender;
	TextView txtBDay;
	TextView txtPhone;
	TextView txtAddress;
	TextView txtPassword;
	TextView txtDeviceID;
	TextView txtMake;
	TextView txtModel;
	TextView txtYear;
	TextView txtColor;
	TextView txtLicensePlate;
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
		setContentView(R.layout.profile);

		ActionBar actionBar = getActionBar();
		actionBar.hide();		

		initializeVisualComponents();

		Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource (this,
				R.array.options, R.drawable.spinner);
		adapter.setDropDownViewResource(R.drawable.spinner_dropdown);
		spinner.setAdapter(adapter);
		spinner.setOnItemSelectedListener(this);
		spinner.setSelection(1);
	}

	public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
		if (startUp) {
			if (pos == 0) {
				Intent mainActivity = new Intent(Profile.this, Main.class);
				startActivity(mainActivity);
			}
			else if (pos == 2) {
				//TODO: Logout confirmation.
			}
		}

		startUp = true;
	}

	public void onNothingSelected(AdapterView<?> parent) {
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnEditInfo) {
			btnEditInfo.setVisibility(View.INVISIBLE);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			tblUserInfo.setVisibility(View.INVISIBLE);
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);

			setEditableInfo();
		}
		else if (v.getId() == R.id.btnCancel) {
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.INVISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);

			if (imgButtonUserInfo.isShown()) {
				tblUserInfo.setVisibility(View.VISIBLE);
			}
			else {
				tblVehicleInfo.setVisibility(View.VISIBLE);
				//TODO: If user has multiple vehicles
				btnLeftArrow.setVisibility(View.VISIBLE);
				btnRightArrow.setVisibility(View.VISIBLE);
			}
		}
		else if (v.getId() == R.id.btnSave) {
			//TODO: Update information in DB.
			//TODO: Extract info from DB to display again.
			Toast.makeText(this, "New information has been updated.", Toast.LENGTH_LONG).show();
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.INVISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			tblUserTextBoxes.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);

			if (imgButtonUserInfo.isShown()) {
				tblUserInfo.setVisibility(View.VISIBLE);
			}
			else {
				tblVehicleInfo.setVisibility(View.VISIBLE);
				//TODO: If user has multiple vehicles
				btnLeftArrow.setVisibility(View.VISIBLE);
				btnRightArrow.setVisibility(View.VISIBLE);
			}
		}
		else if (v.getId() == R.id.btnUserInfo) {
			btnUserInfo.setTextColor(Color.BLACK);
			btnVehicleInfo.setTextColor(Color.GRAY);
			imgButtonVehicleInfo.setVisibility(View.INVISIBLE);
			imgButtonUserInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.VISIBLE);
			tblUserInfo.setVisibility(View.VISIBLE);
			tblVehicleText.setVisibility(View.INVISIBLE);
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);
		}
		else if (v.getId() == R.id.btnVehicleInfo) {
			btnVehicleInfo.setTextColor(Color.BLACK);
			btnUserInfo.setTextColor(Color.GRAY);
			imgButtonUserInfo.setVisibility(View.INVISIBLE);
			imgButtonVehicleInfo.setVisibility(View.VISIBLE);
			tblUserText.setVisibility(View.INVISIBLE);
			tblUserInfo.setVisibility(View.INVISIBLE);
			tblVehicleText.setVisibility(View.VISIBLE);
			tblVehicleInfo.setVisibility(View.VISIBLE);
			btnRightArrow.setVisibility(View.VISIBLE);
		}
		else if (v.getId() == R.id.btnRightArrow) {
			btnLeftArrow.setVisibility(View.VISIBLE);

			//TODO: If user has multiple vehicles (DB).
			if (false/*user has many vehicles*/) {
				//TODO: Show info of next vehicle (DB).
			}
			else {
				btnUserInfo.setClickable(false);
				btnVehicleInfo.setClickable(false);
				btnRightArrow.setVisibility(View.INVISIBLE);
				tblVehicleInfo.setVisibility(View.INVISIBLE);
				tblVehicleTextBoxes.setVisibility(View.VISIBLE);
				btnEditInfo.setVisibility(View.INVISIBLE);
				btnAddNewVehicle.setVisibility(View.VISIBLE);
			}
		}
		else if (v.getId() == R.id.btnLeftArrow) {
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			
			if (tblVehicleTextBoxes.isShown()) {
				tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
				btnEditInfo.setVisibility(View.INVISIBLE);
				btnAddNewVehicle.setVisibility(View.VISIBLE);
			}
			btnRightArrow.setVisibility(View.VISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			//TODO: Get data from previous vehicle information (DB).
			tblVehicleInfo.setVisibility(View.VISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			if (true/*first vehicle in users vehicle list*/) {
				btnLeftArrow.setVisibility(View.INVISIBLE);
			}

		}
		else if (v.getId() == R.id.btnAddNewVehicle) {
			//TODO: Verify Device ID.
			//Toast.makeText(this, "Device ID does not exist.", Toast.LENGTH_LONG).show();
			//TODO: Verify if all fields are filled (Toast if not).
			//Toast.makeText(this, "All fields must be filled.", Toast.LENGTH_LONG).show();
			//TODO: Save information in new line of vehicle table.
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			Toast.makeText(this, "New vehicle has been added to your profile.", Toast.LENGTH_LONG).show();
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			//TODO: Extract newly added info and put it in this table.
			tblVehicleInfo.setVisibility(View.VISIBLE);
			btnEditInfo.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
		}
	}


	private void initializeVisualComponents() {
		btnSave = (Button) findViewById(R.id.btnSave);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnEditInfo = (Button) findViewById(R.id.btnEditInfo);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);
		btnAddNewVehicle = (Button) findViewById(R.id.btnAddNewVehicle);
		btnLeftArrow = (ImageButton) findViewById(R.id.btnLeftArrow);
		btnRightArrow = (ImageButton) findViewById(R.id.btnRightArrow);

		imgButtonDouble = (ImageView) findViewById(R.id.imgButtonDouble);
		imgButtonUserInfo = (ImageView) findViewById(R.id.imgButtonUserInfo);
		imgButtonVehicleInfo = (ImageView) findViewById(R.id.imgButtonVehicleInfo);

		tblUserText = (TableLayout) findViewById(R.id.tblUserText);
		tblUserInfo = (TableLayout) findViewById(R.id.tblUserInfo);
		tblVehicleText = (TableLayout) findViewById(R.id.tblVehicleText);
		tblVehicleInfo = (TableLayout) findViewById(R.id.tblVehicleInfo);
		tblUserTextBoxes = (TableLayout) findViewById(R.id.tblUserTextBoxes);
		tblVehicleTextBoxes = (TableLayout) findViewById(R.id.tblVehicleTextBoxes);

		txtFName = (TextView) findViewById(R.id.txtFName);
		txtLName = (TextView) findViewById(R.id.txtLName);
		txtEmail = (TextView) findViewById(R.id.txtEmail);
		txtGender = (TextView) findViewById(R.id.txtGender);
		txtBDay = (TextView) findViewById(R.id.txtBDay);
		txtPhone = (TextView) findViewById(R.id.txtPhone);
		txtAddress = (TextView) findViewById(R.id.txtAddress);
		txtPassword = (TextView) findViewById(R.id.txtPassword);

		txtDeviceID = (TextView) findViewById(R.id.txtDeviceID);
		txtMake = (TextView) findViewById(R.id.txtMake);
		txtModel = (TextView) findViewById(R.id.txtModel);
		txtYear = (TextView) findViewById(R.id.txtYear);
		txtColor = (TextView) findViewById(R.id.txtColor);
		txtLicensePlate = (TextView) findViewById(R.id.txtLicensePlate);

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

		btnEditInfo.setOnClickListener(this);
		btnSave.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
		btnLeftArrow.setOnClickListener(this);
		btnRightArrow.setOnClickListener(this);
		btnAddNewVehicle.setOnClickListener(this);
	}

	private void setEditableInfo() {
		btnLeftArrow.setVisibility(View.INVISIBLE);
		btnRightArrow.setVisibility(View.INVISIBLE);

		if (imgButtonUserInfo.isShown()) {
			txbFName.setText(txtFName.getText());
			txbLName.setText(txtLName.getText());
			txbEmail.setText(txtEmail.getText());
			txbGender.setText(txtGender.getText());
			txbBDay.setText(txtBDay.getText());
			txbPhone.setText(txtPhone.getText());
			txbAddress.setText(txtAddress.getText());
			txbPassword.setText(txtPassword.getText());

			tblUserTextBoxes.setVisibility(View.VISIBLE);
		}
		else {
			txbDeviceID.setText(txtDeviceID.getText());
			txbMake.setText(txtMake.getText());
			txbModel.setText(txtModel.getText());
			txbYear.setText(txtYear.getText());
			txbColor.setText(txtColor.getText());
			txbLicensePlate.setText(txtLicensePlate.getText());

			tblVehicleTextBoxes.setVisibility(View.VISIBLE);
		}
	}
}
