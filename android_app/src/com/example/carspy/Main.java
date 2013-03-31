package com.example.carspy;

import java.sql.Connection;

import java.sql.DriverManager;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.apache.http.NameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;
import org.json.JSONStringer;

import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.View;
import android.view.animation.DecelerateInterpolator;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.Spinner;
import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.animation.AnimatorSet;
import android.animation.ObjectAnimator;
import android.app.ActionBar;
import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Point;
import android.graphics.Rect;

public class Main extends FragmentActivity implements OnItemSelectedListener {
	private Animator mCurrentAnimator;
	private int mShortAnimationDuration;

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		ActionBar actionBar = getActionBar();
		actionBar.hide();
			
		Spinner spinner = (Spinner) findViewById(R.id.spnOptions);
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource (this,
				R.array.options, R.drawable.spinner);
		adapter.setDropDownViewResource(R.drawable.spinner_dropdown);
		spinner.setAdapter(adapter);
		spinner.setOnItemSelectedListener(this);

		String dates[] = {"1/11/13","1/12/13","1/14/13"};
		String times[] = {"10:43am","11:35am","1:12pm"};

		Spinner spnDate = (Spinner) findViewById(R.id.spnDate);
		Spinner spnTime = (Spinner) findViewById(R.id.spnTime);

		ArrayAdapter<String> spnArrayDate = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, dates);
		spnArrayDate.setDropDownViewResource(R.drawable.spinner_dropdown_orange);
		spnDate.setAdapter(spnArrayDate);

		ArrayAdapter<String> spnArrayTime = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, times);
		spnArrayTime.setDropDownViewResource(R.drawable.spinner_dropdown_orange);
		spnTime.setAdapter(spnArrayTime);

		final View thumbView1 = findViewById(R.id.imgPhoto1);
		thumbView1.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View view) {
				zoomImageFromThumb(thumbView1, R.drawable.person);
			}
		});

		final View thumbView2 = findViewById(R.id.imgPhoto2);
		thumbView2.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View view) {
				zoomImageFromThumb(thumbView2, R.drawable.person);
			}
		});

		final View thumbView3 = findViewById(R.id.imgPhoto3);
		thumbView3.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View view) {
				zoomImageFromThumb(thumbView3, R.drawable.person);
			}
		});

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

	public void onItemSelected(AdapterView<?> parent, View view, int pos, long i) {
		if (pos == 1) {
			Intent profileActivity = new Intent(Main.this, Profile.class);
			startActivity(profileActivity);
		}
		else if (pos == 2)
		{
			//TODO: Logout confirmation.
		}
	}

	public void onNothingSelected(AdapterView<?> parent) {
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
}
