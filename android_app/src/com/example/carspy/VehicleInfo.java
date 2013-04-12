package com.example.carspy;

import java.util.ArrayList;

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

public class VehicleInfo extends Activity implements OnClickListener {
	private boolean addNewMode = false;
	private int vehicleIndex = 0;

	private Button btnSave;
	private Button btnCancel;
	private Button btnUserInfo;
	private Button btnVehicleInfo;
	private Button btnAddNewVehicle;
	private Button btnEditInfoSmall;

	private ImageButton btnLeftArrow;
	private ImageButton btnRightArrow;

	private ImageView imgButtonDouble;

	private TableLayout tblVehicleInfo;
	private TableLayout tblVehicleTextBoxes;

	private TextView txtDeviceID;
	private TextView txtMake;
	private TextView txtModel;
	private TextView txtYear;
	private TextView txtColor;
	private TextView txtLicensePlate;

	private EditText txbDeviceID;
	private EditText txbMake;
	private EditText txbModel;
	private EditText txbYear;
	private EditText txbColor;
	private EditText txbLicensePlate;

	private ArrayList<Vehicle> vehicles;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.vehicle_info);

		ActionBar actionBar = getActionBar();
		actionBar.hide();		

		initializeVisualComponents();

		Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource (this,
				R.array.options, R.drawable.spinner);
		adapter.setDropDownViewResource(R.drawable.spinner_dropdown);
		spinner.setAdapter(adapter);
		spinner.setOnItemSelectedListener(new OptionOnItemSelectedListener());
		spinner.setSelection(1);

		vehicles = new ArrayList<Vehicle>();
		vehicles.add(new Vehicle("1", "Toyota", "Matrix", "Black", "2003", "TED-901"));

		updateTxtTable(vehicleIndex);
	}

	private class OptionOnItemSelectedListener implements OnItemSelectedListener {
		public void onItemSelected(AdapterView<?> parent, View view, int pos,long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
			String chosenOption = (String) spinner.getSelectedItem();

			if (chosenOption.equals("Home")) {
				Intent mainActivity = new Intent(VehicleInfo.this, Main.class);
				startActivity(mainActivity);
			}
			else if (chosenOption.equals("Logout")) {
				Intent loginActivity = new Intent(VehicleInfo.this, Login.class);
				startActivity(loginActivity);
			}
		}

		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}

	}

	public void onNothingSelected(AdapterView<?> parent) {

	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnEditInfoSmall) {
			setTextBoxes();
			addNewMode = false;
			txbDeviceID.setClickable(false);
			txbDeviceID.setFocusable(false);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			btnEditInfoSmall.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.VISIBLE);	
		}
		else if (v.getId() == R.id.btnCancel) {
			imgButtonDouble.setVisibility(View.VISIBLE);
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			btnAddNewVehicle.setVisibility(View.VISIBLE);
			btnEditInfoSmall.setVisibility(View.VISIBLE);
			tblVehicleInfo.setVisibility(View.VISIBLE);
			verifyArrows();
		}
		else if (v.getId() == R.id.btnSave) {
			//TODO: Update information in DB.
			//TODO: Extract info from DB to display again.

			if (addNewMode) {
				addVehicle();
				Toast.makeText(this, "New vehicle has been added.", Toast.LENGTH_LONG).show();
				//TODO: Add new vehicle in DB.
			}
			else {
				setTxtInfo(vehicleIndex);
				updateTxtTable(vehicleIndex);
				Toast.makeText(this, "Vehicle information has been updated.", Toast.LENGTH_LONG).show();
				//TODO: Update vehicle information in DB.
			}
			btnSave.setVisibility(View.INVISIBLE);
			btnCancel.setVisibility(View.INVISIBLE);
			imgButtonDouble.setVisibility(View.VISIBLE);
			tblVehicleTextBoxes.setVisibility(View.INVISIBLE);
			btnUserInfo.setClickable(true);
			btnVehicleInfo.setClickable(true);
			tblVehicleInfo.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.VISIBLE);
			btnEditInfoSmall.setVisibility(View.VISIBLE);
		}
		else if (v.getId() == R.id.btnUserInfo) {
			Intent userInfoActivity = new Intent(VehicleInfo.this, UserInfo.class);
			startActivity(userInfoActivity);
		}
		else if (v.getId() == R.id.btnRightArrow) {

			vehicleIndex += 1;
			updateTxtTable(vehicleIndex);
			verifyArrows();
		}
		else if (v.getId() == R.id.btnLeftArrow) {
			vehicleIndex -= 1;
			updateTxtTable(vehicleIndex);
			verifyArrows();
		}
		else if (v.getId() == R.id.btnAddNewVehicle) {
			//TODO: Verify Device ID.
			//Toast.makeText(this, "Device ID does not exist.", Toast.LENGTH_LONG).show();
			//TODO: Verify if all fields are filled (Toast if not).
			//Toast.makeText(this, "All fields must be filled.", Toast.LENGTH_LONG).show();
			//TODO: Save information in new line of vehicle table.
			addNewMode = true;
			resetTextBoxes();
			txbDeviceID.setClickable(true);
			txbDeviceID.setFocusable(true);	
			txbDeviceID.setFocusableInTouchMode(true);
			btnUserInfo.setClickable(false);
			btnVehicleInfo.setClickable(false);
			//TODO: Extract newly added info and put it in this table.
			tblVehicleInfo.setVisibility(View.INVISIBLE);
			tblVehicleTextBoxes.setVisibility(View.VISIBLE);
			btnSave.setVisibility(View.VISIBLE);
			btnCancel.setVisibility(View.VISIBLE);
			btnAddNewVehicle.setVisibility(View.INVISIBLE);
			btnEditInfoSmall.setVisibility(View.INVISIBLE);
			btnLeftArrow.setVisibility(View.INVISIBLE);
			btnRightArrow.setVisibility(View.INVISIBLE);
		}
	}


	private void initializeVisualComponents() {
		btnSave = (Button) findViewById(R.id.btnSave);
		btnCancel = (Button) findViewById(R.id.btnCancel);
		btnUserInfo = (Button) findViewById(R.id.btnUserInfo);
		btnVehicleInfo = (Button) findViewById(R.id.btnVehicleInfo);
		btnAddNewVehicle = (Button) findViewById(R.id.btnAddNewVehicle);
		btnEditInfoSmall = (Button) findViewById(R.id.btnEditInfoSmall);
		btnLeftArrow = (ImageButton) findViewById(R.id.btnLeftArrow);
		btnRightArrow = (ImageButton) findViewById(R.id.btnRightArrow);

		imgButtonDouble = (ImageView) findViewById(R.id.imgButtonDouble);

		tblVehicleInfo = (TableLayout) findViewById(R.id.tblVehicleInfo);
		tblVehicleTextBoxes = (TableLayout) findViewById(R.id.tblVehicleTextBoxes);

		txtDeviceID = (TextView) findViewById(R.id.txtDeviceID);
		txtMake = (TextView) findViewById(R.id.txtMake);
		txtModel = (TextView) findViewById(R.id.txtModel);
		txtYear = (TextView) findViewById(R.id.txtYear);
		txtColor = (TextView) findViewById(R.id.txtColor);
		txtLicensePlate = (TextView) findViewById(R.id.txtLicensePlate);

		txbDeviceID = (EditText) findViewById(R.id.txbDeviceID);
		txbMake = (EditText) findViewById(R.id.txbMake);
		txbModel = (EditText) findViewById(R.id.txbModel);
		txbYear = (EditText) findViewById(R.id.txbYear);
		txbColor = (EditText) findViewById(R.id.txbColor);
		txbLicensePlate = (EditText) findViewById(R.id.txbLicensePlate);

		btnSave.setOnClickListener(this);
		btnCancel.setOnClickListener(this);
		btnUserInfo.setOnClickListener(this);
		btnVehicleInfo.setOnClickListener(this);
		btnLeftArrow.setOnClickListener(this);
		btnRightArrow.setOnClickListener(this);
		btnAddNewVehicle.setOnClickListener(this);
		btnEditInfoSmall.setOnClickListener(this);
	}

	private void verifyArrows() {
		if (vehicleIndex > 0) {
			btnLeftArrow.setVisibility(View.VISIBLE);
		}
		else {
			btnLeftArrow.setVisibility(View.INVISIBLE);
		}
		if (vehicleIndex < vehicles.size() - 1) {
			btnRightArrow.setVisibility(View.VISIBLE);
		}
		else {
			btnRightArrow.setVisibility(View.INVISIBLE);
		}
	}

	private void setTextBoxes() {
		txbDeviceID.setText(txtDeviceID.getText());
		txbMake.setText(txtMake.getText());
		txbModel.setText(txtModel.getText());
		txbYear.setText(txtYear.getText());
		txbColor.setText(txtColor.getText());
		txbLicensePlate.setText(txtLicensePlate.getText());
	}

	private void resetTextBoxes() {
		txbDeviceID.setText("");
		txbMake.setText("");
		txbModel.setText("");
		txbYear.setText("");
		txbColor.setText("");
		txbLicensePlate.setText("");
	}

	private void updateTxtTable(int index) {
		txtDeviceID.setText(vehicles.get(index).getDeviceID());
		txtMake.setText(vehicles.get(index).getMake());
		txtModel.setText(vehicles.get(index).getModel());
		txtColor.setText(vehicles.get(index).getColor());
		txtYear.setText(vehicles.get(index).getYear());
		txtLicensePlate.setText(vehicles.get(index).getLicensePlate());
	}

	private void setTxtInfo(int index) {
		vehicles.get(index).setDeviceID(txbDeviceID.getText().toString());
		vehicles.get(index).setMake(txbMake.getText().toString());
		vehicles.get(index).setModel(txbModel.getText().toString());
		vehicles.get(index).setColor(txbColor.getText().toString());
		vehicles.get(index).setYear(txbYear.getText().toString());
		vehicles.get(index).setLicensePlate(txbLicensePlate.getText().toString());
	}

	private void addVehicle() {
		vehicles.add(new Vehicle(txbDeviceID.getText().toString(), txbMake.getText().toString(), txbModel.getText().toString(), 
				txbColor.getText().toString(), txbYear.getText().toString(), txbLicensePlate.getText().toString()));
		vehicleIndex = vehicles.size() - 1;
		updateTxtTable(vehicleIndex);
		btnLeftArrow.setVisibility(View.VISIBLE);
	}

	private class Vehicle {
		private String deviceID;
		private String make;
		private String model;
		private String color;
		private String year;
		private String licensePlate;

		public Vehicle(String deviceID, String make, String model, String color, String year,
				String licensePlate) {
			super();
			this.deviceID = deviceID;
			this.make = make;
			this.model = model;
			this.color = color;
			this.year = year;
			this.licensePlate = licensePlate;
		}

		public String getDeviceID() {
			return deviceID;
		}

		public void setDeviceID(String deviceID) {
			this.deviceID = deviceID;
		}

		public String getMake() {
			return make;
		}

		public void setMake(String make) {
			this.make = make;
		}

		public String getModel() {
			return model;
		}

		public void setModel(String model) {
			this.model = model;
		}

		public String getColor() {
			return color;
		}

		public void setColor(String color) {
			this.color = color;
		}

		public String getYear() {
			return year;
		}

		public void setYear(String year) {
			this.year = year;
		}

		public String getLicensePlate() {
			return licensePlate;
		}

		public void setLicensePlate(String licensePlate) {
			this.licensePlate = licensePlate;
		}


	}
}
