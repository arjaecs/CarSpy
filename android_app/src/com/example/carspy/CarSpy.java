package com.example.carspy;

import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.app.ActionBar;
import android.app.Activity;
import android.content.Intent;

public class CarSpy extends Activity implements OnClickListener {
	ImageButton btnTransparent;
	Handler handler;
	private final Runnable run = new Runnable() {
		public void run() {

			Intent loginActivity = new Intent(CarSpy.this, Login.class);
			startActivity(loginActivity);
		}
	};

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.carspy);

		ActionBar actionBar = getActionBar();
		actionBar.hide();

		btnTransparent = (ImageButton) findViewById(R.id.btnTransparent);
		btnTransparent.setOnClickListener(this);

		long timeDelay = 5000; 
		handler = new Handler();
		handler.postDelayed(run, timeDelay);
	}

	public void onClick(View v) {
		if (v.getId() == R.id.btnTransparent) {
			handler.removeCallbacks(run);
			handler.post(run);
		}
	}
}
