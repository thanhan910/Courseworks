package com.example.taskapp.ui.add

import android.annotation.SuppressLint
import android.content.DialogInterface
import android.os.Build
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import android.view.inputmethod.InputMethodManager
import android.widget.*
import androidx.appcompat.app.AlertDialog
import androidx.core.content.ContextCompat
import androidx.core.view.WindowCompat
import androidx.fragment.app.viewModels
import com.example.taskapp.application.MyApplication
import com.example.taskapp.R
import com.example.taskapp.data.data.Task
import com.example.taskapp.databinding.FragmentAddBinding
import com.example.taskapp.ui.edittext.EditTextFragment
import com.example.taskapp.ui.utils.formatDate
import com.example.taskapp.ui.utils.getStarIcon
import com.example.taskapp.ui.utils.showDateTimePicker
import com.example.taskapp.ui.utils.showNumberPicker
import com.google.android.material.bottomsheet.BottomSheetDialogFragment

/**
 *
 * A fragment that shows a list of items as a modal bottom sheet.
 *
 * You can show this modal bottom sheet from your activity like this:
 * <pre>
 *    ItemListDialogFragment.newInstance(30).show(supportFragmentManager, "dialog")
 * </pre>
 */

class AddFragment : BottomSheetDialogFragment() {

    private val viewModel: AddViewModel by viewModels {
        AddViewModelFactory((activity?.application as MyApplication).repository)
    }

    private var _binding: FragmentAddBinding? = null

    // This property is only valid between onCreateView and
    // onDestroyView.
    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {

        _binding = FragmentAddBinding.inflate(inflater, container, false)

        // set this to adjust the bottom fragment to fit when soft keyboard appears on screen
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.R) {
            requireDialog().window?.let { WindowCompat.setDecorFitsSystemWindows(it, false) }
        } else {
            @Suppress("DEPRECATION")
            requireDialog().window?.setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_ADJUST_RESIZE)
        }

        return binding.root
    }

    @SuppressLint("SetTextI18n")
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {

        // show an alert when click outside of fragment
        dialog!!.window
            ?.decorView
            ?.findViewById<View>(com.google.android.material.R.id.touch_outside)
            ?.setOnClickListener {
                onClickOutside()
            }

        // show keyboard immediately to input the name
        val imm: InputMethodManager = ContextCompat.getSystemService(
            view.context,
            InputMethodManager::class.java
        ) as InputMethodManager

        // when this fragment changes state and returns, the keyboard will focus on the latest focusing view
        val currentView = savedInstanceState?.getInt("CURRENT FOCUS")?.let { view.findViewById<EditText>(it) }

        if (currentView != null) {
            currentView.requestFocus()
            imm.showSoftInput(currentView, InputMethodManager.SHOW_IMPLICIT)
        }
        else {
            binding.nameView.requestFocus()
            imm.showSoftInput(binding.nameView, InputMethodManager.SHOW_IMPLICIT)
        }

        viewModel.name.observe(viewLifecycleOwner) {

            if (it.isNotEmpty()) {
                binding.saveButton.setBackgroundColor(ContextCompat.getColor(binding.root.context, R.color.teal_700))
            } else {
                binding.saveButton.setBackgroundColor(ContextCompat.getColor(binding.root.context, R.color.backgroundOff))
            }
        }

        viewModel.starred.observe(viewLifecycleOwner) {
            binding.starIcon.setImageDrawable(getStarIcon(it, binding.root.context))
        }

        viewModel.estimate.observe(viewLifecycleOwner) {
            val button = binding.estimateButton
            button.text = when(it) {
                null -> resources.getString(R.string.estimate)
                1 -> "1 day"
                else -> "$it days"
            }
        }

        val datePattern = "EEE, MMM d"

        viewModel.due.observe(viewLifecycleOwner) {
            val button = binding.dueButton
            button.text = formatDate(it, datePattern, resources.getString(R.string.set_due_date))
        }

        viewModel.plan.observe(viewLifecycleOwner) {
            val button = binding.planButton
            button.text = formatDate(it, datePattern, resources.getString(R.string.plan_task))
        }

        viewModel.remind.observe(viewLifecycleOwner) {
            val button = binding.remindButton
            button.text = formatDate(it, datePattern, resources.getString(R.string.remind_me))
        }

        viewModel.description.observe(viewLifecycleOwner) {
            if(it.isNullOrEmpty()) {
                binding.descriptionView.text = null
            }
            else {
                if(it.length > 20) {
                    binding.descriptionView.text = "${it.subSequence(0, 16)}..."
                }
                else {
                    binding.descriptionView.text = it
                }
            }
        }

        binding.starIcon.setOnClickListener {
            viewModel.switchStarred()
        }

        binding.estimateButton.setOnClickListener {
            showNumberPicker (binding.root.context, viewModel.getEstimate(), { value ->
                viewModel.setEstimate(value)
            }, {
                viewModel.setEstimate(null)
            })
        }

        binding.dueButton.setOnClickListener {

            showDateTimePicker (binding.root.context, null, { calendar ->
                viewModel.setDue(calendar.time)
            }, {
                viewModel.setDue(null)
            })
        }

        binding.planButton.setOnClickListener {

            showDateTimePicker (binding.root.context, null, {
                viewModel.setPlan(it.time)
            }, {
                viewModel.setPlan(null)
            })
        }

        binding.remindButton.setOnClickListener {
            showDateTimePicker (binding.root.context, null, {
                viewModel.setRemind(it.time)
            }, {
                viewModel.setRemind(null)
            })
        }


        // track the text being written into the view. If it is not empty then change the color of the add button
        binding.nameView.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(str: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(str: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(str: Editable) {
                val s = str.toString().trim { it <= ' ' }
                viewModel.setName(s)
            }
        })

        childFragmentManager.setFragmentResultListener(EditTextFragment.REQUEST_KEY, viewLifecycleOwner) { key, bundle ->
            val n = bundle.getString(EditTextFragment.ARG_NAME)?.trim { it <= ' '} ?: ""
            viewModel.setName(n)
            binding.nameView.setText(n)
            val d = bundle.getString(EditTextFragment.ARG_DESCRIPTION)
            viewModel.setDescription(d)
        }

        binding.descriptionView.setOnClickListener {
            val editTextFragment = EditTextFragment.newInstance(
                viewModel.name.value ?: "",
                viewModel.description.value ?: "",
                EditTextFragment.DESCRIPTION_VIEW
            )

            editTextFragment.show(childFragmentManager, "EditText")
        }

        binding.saveButton.setOnClickListener {

            val name = binding.nameView.text.toString().trim { it <= ' ' }
            viewModel.setName(name)

            if (name.isNotEmpty()) {

                viewModel.insert(viewModel.getTask())
                viewModel.reset()
                binding.nameView.text = null

                Toast.makeText(context, "New task added!", Toast.LENGTH_SHORT).show()
            }

            else {
                binding.nameView.error = "Task name cannot be empty"
                Toast.makeText(context, "Task not added: Task name cannot be empty.", Toast.LENGTH_SHORT).show()
            }
        }
    }

    override fun onSaveInstanceState(outState: Bundle) {

        // save the currently focusing view's id
        activity?.currentFocus?.let { outState.putInt("CURRENT FOCUS", it.id) }

        super.onSaveInstanceState(outState)
    }

    private fun onClickOutside() {

        if(viewModel.getTask() != Task()) {
            val dialogBuilder = context?.let { it1 -> AlertDialog.Builder(it1) }
            dialogBuilder?.setTitle("Discard changes?")
            dialogBuilder?.setMessage("The changes you have made will not be saved.")
            dialogBuilder?.setPositiveButton("Discard") { _, _ ->
                dismiss()
            }
            dialogBuilder?.setNegativeButton("Cancel") { d, _ ->
                d.cancel()
            }
            dialogBuilder?.create()?.show()
        }

        else {

            dismiss()
        }
    }

    override fun onDismiss(dialog: DialogInterface) {
        super.onDismiss(dialog)
        viewModel.reset()
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
        //         * @param id Parameter 1.
         * @return A new instance of fragment DetailFragment.
         */
        fun newInstance() = AddFragment().apply {
            arguments = Bundle().apply {}
        }
    }
}