package com.example.carspy;

import java.util.ArrayList;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.View;
import android.view.animation.DecelerateInterpolator;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.animation.AnimatorSet;
import android.animation.ObjectAnimator;
import android.app.ActionBar;
import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Point;
import android.graphics.Rect;

public class Main extends FragmentActivity {
	private Animator mCurrentAnimator;
	private int mShortAnimationDuration;

	private ArrayList<CustomList> vehicleList;
	private ArrayList<CustomList> dateList;
	private ArrayList<Session> sessions;

	private Spinner spnOptions;
	private Spinner spnVehicle;
	private Spinner spnDate;
	private Spinner spnTime;

	private TextView txtGPSLong;
	private TextView txtGPSLat;

	private ImageButton imgPhoto1;
	private ImageButton imgPhoto2;
	private ImageButton imgPhoto3;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		ActionBar actionBar = getActionBar();
		actionBar.hide();

		txtGPSLong = (TextView) findViewById(R.id.txtGPSLong);
		txtGPSLat = (TextView) findViewById(R.id.txtGPSLat);
		imgPhoto1 = (ImageButton) findViewById(R.id.imgPhoto1);;
		imgPhoto2 = (ImageButton) findViewById(R.id.imgPhoto2);;
		imgPhoto3 = (ImageButton) findViewById(R.id.imgPhoto3);;


		spnOptions = (Spinner) findViewById(R.id.spnOptions);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource (this,
				R.array.options, R.drawable.spinner);
		adapter.setDropDownViewResource(R.drawable.spinner_dropdown);
		spnOptions.setAdapter(adapter);
		spnOptions.setOnItemSelectedListener(new OptionOnItemSelectedListener());


		//TODO: Automatic method of making these list dynamically when information is received from DB.
		sessions = new ArrayList<Session>();
		sessions.add(new Session("Toyota Matrix", "3/4/13", "10:39pm", "18.22325", "-66.59343", 
				"person.png", "person.png", "person.png"));
		sessions.add(new Session("Toyota Matrix", "3/4/13", "9:55pm", "18.19832", "-65.67443", 
				"person2.jpg", "person2.jpg", "person2.jpg"));
		sessions.add(new Session("Toyota Matrix", "3/5/13", "3:02pm", "18.73223", "-65.64589", 
				"person1.jpeg", "person1.jpeg", "person1.jpeg"));
		sessions.add(new Session("Mazda RX5", "3/5/13", "10:41am", "19.22325", "-67.67424", 
				"person3.jpg", "person3.jpg", "person3.jpg"));

		String vehicles[] = {"Toyota Matrix", "Mazda RX5"};
		String dates1[] = {"3/7/13", "3/4/13"};
		String dates2[] = {"3/5/13"};
		String times1[] = {"10:39pm","9:55pm"};
		String times2[] = {"3:02pm"};
		String times3[] = {"10:41am"};

		CustomList vehicleList1 = new CustomList(vehicles[0], dates1);
		CustomList vehicleList2 = new CustomList(vehicles[1], dates2);
		CustomList dateList1 = new CustomList(dates1[0], times1);
		CustomList dateList2 = new CustomList(dates1[1], times2);
		CustomList dateList3 = new CustomList(dates2[0], times3);

		vehicleList = new ArrayList<CustomList>();
		dateList = new ArrayList<CustomList>();

		vehicleList.add(vehicleList1);
		vehicleList.add(vehicleList2);
		dateList.add(dateList1);
		dateList.add(dateList2);
		dateList.add(dateList3);

		spnDate = (Spinner) findViewById(R.id.spnDate);
		spnTime = (Spinner) findViewById(R.id.spnTime);
		spnVehicle = (Spinner) findViewById(R.id.spnVehicle);

		updateVehicleSpinner(vehicles);
		spnVehicle.setOnItemSelectedListener(new VehicleOnItemSelectedListener());

		//updateDateSpinner(dates1);
		spnDate.setOnItemSelectedListener(new DateOnItemSelectedListener());

		//updateTimeSpinner(times1);
		spnTime.setOnItemSelectedListener(new TimeOnItemSelectedListener());

		final View thumbViewMap = findViewById(R.id.imgMap);
		thumbViewMap.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View view) {
				zoomImageFromThumb(thumbViewMap, R.drawable.map);
			}
		});

		mShortAnimationDuration = getResources().getInteger(
				android.R.integer.config_shortAnimTime);
	}

	private void updateDateSpinner(String date[]) {
		ArrayAdapter<String> spnArrayDate = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, date);
		spnArrayDate.setDropDownViewResource(R.drawable.spinner_dropdown_orange);
		spnDate.setAdapter(spnArrayDate);
	}

	private void updateTimeSpinner(String time[]) {
		ArrayAdapter<String> spnArrayTime = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, time);
		spnArrayTime.setDropDownViewResource(R.drawable.spinner_dropdown_orange);
		spnTime.setAdapter(spnArrayTime);
	}

	private void updateVehicleSpinner(String vehicle[]) {
		ArrayAdapter<String> spnArrayVehicle = new ArrayAdapter<String>(this, R.drawable.spinner_middle, vehicle);
		spnArrayVehicle.setDropDownViewResource(R.drawable.spinner_dropdown);
		spnVehicle.setAdapter(spnArrayVehicle);
	}

	private class OptionOnItemSelectedListener implements OnItemSelectedListener {
		public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
			String chosenOption = (String) spinner.getSelectedItem();

			if (chosenOption.equals("View Profile")) {
				Intent profileActivity = new Intent(Main.this, UserInfo.class);
				startActivity(profileActivity);
			}
			else if (chosenOption.equals("Logout")) {
				Intent loginActivity = new Intent(Main.this, Login.class);
				startActivity(loginActivity);
			}
		}

		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}
	}

	private class TimeOnItemSelectedListener implements OnItemSelectedListener {

		public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnTime);
			String chosenOption = (String) spinner.getSelectedItem();

			int size = sessions.size();
			for (int i = 0; size > i; i++) {
				if (chosenOption.equals(sessions.get(i).getHour())) {
					//TODO: Update map.
					txtGPSLong.setText(sessions.get(i).getLongitude());
					txtGPSLat.setText(sessions.get(i).getLatitude());

					String picName = sessions.get(i).getPicPath1();
					picName = picName.replace(".jpeg", "");
					picName = picName.replace(".jpg", "");
					picName = picName.replace(".png", "");

					Resources r = getResources();
					final int picId = r.getIdentifier(picName, "drawable", getPackageName());

					imgPhoto1.setBackgroundResource(picId);
					imgPhoto2.setBackgroundResource(picId);
					imgPhoto3.setBackgroundResource(picId);

					final View thumbView1 = findViewById(R.id.imgPhoto1);
					thumbView1.setOnClickListener(new View.OnClickListener() {
						@Override
						public void onClick(View view) {
							zoomImageFromThumb(thumbView1, picId);
						}
					});

					final View thumbView2 = findViewById(R.id.imgPhoto2);
					thumbView2.setOnClickListener(new View.OnClickListener() {
						@Override
						public void onClick(View view) {
							zoomImageFromThumb(thumbView2, picId);
						}
					});

					final View thumbView3 = findViewById(R.id.imgPhoto3);
					thumbView3.setOnClickListener(new View.OnClickListener() {
						@Override
						public void onClick(View view) {
							zoomImageFromThumb(thumbView3, picId);
						}
					});
					
					break;
				}
			}
		}
		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}
	}

	private class VehicleOnItemSelectedListener implements OnItemSelectedListener {

		public void onItemSelected(AdapterView<?> parent, View view, int pos, long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnVehicle);
			String chosenOption = (String) spinner.getSelectedItem();
			String date[] = null;

			int size = vehicleList.size();
			for (int i = 0; size > i; i++) {
				if (chosenOption.equals(vehicleList.get(i).getString())) {
					date = vehicleList.get(i).getArray();
					break;
				}
			}

			updateDateSpinner(date);
		}

		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}
	}

	private class DateOnItemSelectedListener implements OnItemSelectedListener {

		public void onItemSelected(AdapterView<?> parent, View view, int pos,long id) {
			Spinner spinner = (Spinner) findViewById(R.id.spnDate);
			String chosenOption = (String) spinner.getSelectedItem();
			String time[] = null;

			int size = dateList.size();

			for (int i = 0; size > i; i++) {
				if (chosenOption.equals(dateList.get(i).getString())) {
					time = dateList.get(i).getArray();
					break;
				}
			}

			updateTimeSpinner(time);
		}

		@Override
		public void onNothingSelected(AdapterView<?> arg0) {
			// TODO Auto-generated method stub
		}
	}

	private void zoomImageFromThumb(final View thumbView, int imageResId) {

		if (mCurrentAnimator != null) {
			mCurrentAnimator.cancel();
		}

		final ImageView expandedImageView = (ImageView) findViewById(
				R.id.imgExpanded);
		expandedImageView.setImageResource(imageResId);

		final Rect startBounds = new Rect();
		final Rect finalBounds = new Rect();
		final Point globalOffset = new Point();

		thumbView.getGlobalVisibleRect(startBounds);
		findViewById(R.id.actMain)
		.getGlobalVisibleRect(finalBounds, globalOffset);
		startBounds.offset(-globalOffset.x, -globalOffset.y);
		finalBounds.offset(-globalOffset.x, -globalOffset.y);

		float startScale;
		if ((float) finalBounds.width() / finalBounds.height()
				> (float) startBounds.width() / startBounds.height()) {

			startScale = (float) startBounds.height() / finalBounds.height();
			float startWidth = startScale * finalBounds.width();
			float deltaWidth = (startWidth - startBounds.width()) / 2;
			startBounds.left -= deltaWidth;
			startBounds.right += deltaWidth;
		} 

		else {
			startScale = (float) startBounds.width() / finalBounds.width();
			float startHeight = startScale * finalBounds.height();
			float deltaHeight = (startHeight - startBounds.height()) / 2;
			startBounds.top -= deltaHeight;
			startBounds.bottom += deltaHeight;
		}

		thumbView.setAlpha(0f);
		expandedImageView.setVisibility(View.VISIBLE);

		expandedImageView.setPivotX(0f);
		expandedImageView.setPivotY(0f);

		AnimatorSet set = new AnimatorSet();
		set
		.play(ObjectAnimator.ofFloat(expandedImageView, View.X,
				startBounds.left, finalBounds.left))
				.with(ObjectAnimator.ofFloat(expandedImageView, View.Y,
						startBounds.top, finalBounds.top))
						.with(ObjectAnimator.ofFloat(expandedImageView, View.SCALE_X,
								startScale, 1f)).with(ObjectAnimator.ofFloat(expandedImageView,
										View.SCALE_Y, startScale, 1f));
		set.setDuration(mShortAnimationDuration);
		set.setInterpolator(new DecelerateInterpolator());
		set.addListener(new AnimatorListenerAdapter() {
			@Override
			public void onAnimationEnd(Animator animation) {
				mCurrentAnimator = null;
			}

			@Override
			public void onAnimationCancel(Animator animation) {
				mCurrentAnimator = null;
			}
		});
		set.start();
		mCurrentAnimator = set;

		final float startScaleFinal = startScale;
		expandedImageView.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View view) {
				if (mCurrentAnimator != null) {
					mCurrentAnimator.cancel();
				}

				AnimatorSet set = new AnimatorSet();
				set.play(ObjectAnimator
						.ofFloat(expandedImageView, View.X, startBounds.left))
						.with(ObjectAnimator
								.ofFloat(expandedImageView, 
										View.Y,startBounds.top))
										.with(ObjectAnimator
												.ofFloat(expandedImageView, 
														View.SCALE_X, startScaleFinal))
														.with(ObjectAnimator
																.ofFloat(expandedImageView, 
																		View.SCALE_Y, startScaleFinal));
				set.setDuration(mShortAnimationDuration);
				set.setInterpolator(new DecelerateInterpolator());
				set.addListener(new AnimatorListenerAdapter() {
					@Override
					public void onAnimationEnd(Animator animation) {
						thumbView.setAlpha(1f);
						expandedImageView.setVisibility(View.GONE);
						mCurrentAnimator = null;
					}

					@Override
					public void onAnimationCancel(Animator animation) {
						thumbView.setAlpha(1f);
						expandedImageView.setVisibility(View.GONE);
						mCurrentAnimator = null;
					}
				});
				set.start();
				mCurrentAnimator = set;
			}
		});
	}

	private class CustomList {
		private String string;
		private String array[];

		public CustomList(String string, String array[]) {
			this.string = string;
			this.array = array;
		}

		public CustomList(String string, String singleString) {
			String tempArray[] = {singleString};
			this.string = string;
			this.array = tempArray;
		}

		public String getString() {
			return string;
		}

		public void setString(String string) {
			this.string = string;
		}

		public String[] getArray() {
			return array;
		}

		public void setArray(String arrayLists[]) {
			this.array = arrayLists;
		}
	}

	private class Session {
		private String vehicle;
		private String date;
		private String hour;
		private String longitude;
		private String latitude;
		private String picPath1;
		private String picPath2;
		private String picPath3;

		public Session(String vehicle, String date, String hour, String longitude, String latitude, 
				String picPath1, String picPath2, String picPath3) {
			this.vehicle = vehicle;
			this.date = date;
			this.hour = hour;
			this.longitude = longitude;
			this.latitude = latitude;
			this.picPath1 = picPath1;
			this.picPath2 = picPath2;
			this.picPath3 = picPath3;
		}

		public String getVehicle() {
			return vehicle;
		}

		public void setVehicle(String vehicle) {
			this.vehicle = vehicle;
		}

		public String getDate() {
			return date;
		}

		public void setDate(String date) {
			this.date = date;
		}

		public String getHour() {
			return hour;
		}

		public void setHour(String hour) {
			this.hour = hour;
		}

		public String getLongitude() {
			return longitude;
		}

		public void setLongitude(String longitude) {
			this.longitude = longitude;
		}

		public String getLatitude() {
			return latitude;
		}

		public void setLatitude(String latitude) {
			this.latitude = latitude;
		}

		public String getPicPath1() {
			return picPath1;
		}

		public void setPicPath1(String picPath1) {
			this.picPath1 = picPath1;
		}

		public String getPicPath2() {
			return picPath2;
		}

		public void setPicPath2(String picPath2) {
			this.picPath2 = picPath2;
		}

		public String getPicPath3() {
			return picPath3;
		}

		public void setPicPath3(String picPath3) {
			this.picPath3 = picPath3;
		}
	}
}
