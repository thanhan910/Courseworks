package com.example.taskapp.ui.read

import android.annotation.SuppressLint
import android.graphics.Paint
import android.os.Bundle
import android.view.*
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.fragment.app.viewModels
import com.example.taskapp.application.MyApplication
import com.example.taskapp.R
import com.example.taskapp.data.data.Task
import com.example.taskapp.databinding.FragmentReadBinding
import com.example.taskapp.ui.edittext.*
import com.example.taskapp.ui.utils.*
import com.google.android.material.bottomsheet.BottomSheetDialogFragment

private const val ARG_TASK = "task"

class ReadFragment : BottomSheetDialogFragment() {

    private val viewModel: ReadViewModel by viewModels {
        ReadViewModelFactory((activity?.application as MyApplication).repository)
    }

    private var _binding: FragmentReadBinding? = null

    // This property is only valid between onCreateView and
    // onDestroyView.
    private val binding get() = _binding!!

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {
            viewModel.setTask(it.getParcelable<Task>(ARG_TASK) ?: Task())
        }
    }

    override fun onSaveInstanceState(outState: Bundle) {
        outState.putParcelable(ARG_TASK, viewModel.getTask())
        super.onSaveInstanceState(outState)
    }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {

        _binding = FragmentReadBinding.inflate(inflater, container, false)

        registerForContextMenu(binding.checkIcon)

        childFragmentManager.setFragmentResultListener(EditTextFragment.REQUEST_KEY, viewLifecycleOwner) { key, bundle ->
            val n = bundle.getString(EditTextFragment.ARG_NAME) ?: ""
            viewModel.setName(n)
            val d = bundle.getString(EditTextFragment.ARG_DESCRIPTION)
            viewModel.setDescription(d)
        }

        return binding.root
    }

    @SuppressLint("SetTextI18n")
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {

        // Subscribe the UI to the fields in viewModel

        viewModel.name.observe(viewLifecycleOwner) {
            if(it.isNullOrEmpty()) {
                binding.nameView.text = null
            }
            else {
                binding.nameView.text = it
            }
        }

        viewModel.status.observe(viewLifecycleOwner) {
            binding.checkIcon.setImageDrawable(getCheckIcon(it, binding.root.context))
            if(it != 0) {
                binding.nameView.paintFlags = Paint.STRIKE_THRU_TEXT_FLAG
            }
            else {
                binding.nameView.paintFlags = binding.nameView.paintFlags and Paint.STRIKE_THRU_TEXT_FLAG.inv()
            }
        }

        viewModel.starred.observe(viewLifecycleOwner) {
            binding.starIcon.setImageDrawable(getStarIcon(it, binding.root.context))
        }

        viewModel.estimate.observe(viewLifecycleOwner) {
            val button = binding.estimateButton
            button.text = when(it) {
                null -> resources.getString(R.string.estimate_this_task)
                1 -> "1 day"
                else -> "$it days"
            }
        }

        viewModel.due.observe(viewLifecycleOwner) {
            val button = binding.dueButton
            button.text = if(it == null) resources.getString(R.string.set_due_date)
            else "Due " + formatDate(it, "EEE, MMM d, HH:mm")
        }

        viewModel.plan.observe(viewLifecycleOwner) {
            val button = binding.planButton
            button.text = if(it == null) resources.getString(R.string.plan_task)
            else "Planned on " + formatDate(it, "EEE, MMM d, y")
        }

        viewModel.remind.observe(viewLifecycleOwner) {
            val button = binding.remindButton
            button.text = if(it == null) resources.getString(R.string.remind_me)
            else "Remind at " + formatDate(it, "HH:mm, MMM d, y")
        }

        viewModel.description.observe(viewLifecycleOwner) {
            if(it.isNullOrEmpty()) {
                binding.descriptionView.text = null
            }
            else {
                binding.descriptionView.text = it
            }
        }

        // Set the onClickListener events to the UI views

        binding.checkIcon.setOnClickListener {
            val newStatus = when(viewModel.getStatus()) { 0 -> 1 else -> 0 }
            viewModel.setStatus(newStatus)
            if(newStatus == 1)
                Toast.makeText(context, "Task completed!", Toast.LENGTH_SHORT).show()
        }

        binding.starIcon.setOnClickListener {
            viewModel.switchStarred()
            if(viewModel.starred.value == true)
                Toast.makeText(context, "Task starred!", Toast.LENGTH_SHORT).show()
            else
                Toast.makeText(context, "Star removed.", Toast.LENGTH_SHORT).show()
        }

        binding.estimateButton.setOnClickListener {
            showNumberPicker (binding.root.context, viewModel.getEstimate(), { value ->
                viewModel.setEstimate(value)
                val sDayString = if(value == 1) "day" else "days"
                Toast.makeText(context, "Estimated: $value $sDayString to complete task", Toast.LENGTH_SHORT).show()
            }, {
                viewModel.setEstimate(null)
                Toast.makeText(context, "Estimation removed.", Toast.LENGTH_SHORT).show()
            })
        }

        binding.dueButton.setOnClickListener {
            showDateTimePicker (binding.root.context, null, { calendar ->
                viewModel.setDue(calendar.time)
                Toast.makeText(context, "Due date added/edited!", Toast.LENGTH_SHORT).show()
            }, {
                viewModel.setDue(null)
                Toast.makeText(context, "Due date removed!", Toast.LENGTH_SHORT).show()
            })
        }

        binding.planButton.setOnClickListener {

            showDateTimePicker (binding.root.context, null, {
                viewModel.setPlan(it.time)
                Toast.makeText(context, "Task planned! To do on ${formatDate(it.time,"EEE, MMM d")}", Toast.LENGTH_SHORT).show()
            }, {
                viewModel.setPlan(null)
                Toast.makeText(context, "Task plan removed!", Toast.LENGTH_SHORT).show()
            })
        }

        binding.remindButton.setOnClickListener {
            showDateTimePicker (binding.root.context,null, {
                viewModel.setRemind(it.time)
                Toast.makeText(context, "Reminder set at ${formatDate(it.time,"HH:mm, MM d, y")}", Toast.LENGTH_SHORT).show()
            }, {
                viewModel.setRemind(null)
                Toast.makeText(context, "Reminder removed", Toast.LENGTH_SHORT).show()
            })
        }

        binding.nameView.setOnClickListener {
            EditTextFragment.newInstance(
                viewModel.name.value  ?: "", viewModel.description.value ?: ""
                , EditTextFragment.NAME_VIEW).show(childFragmentManager, "EditText")
        }

        binding.descriptionView.setOnClickListener {
            EditTextFragment.newInstance(
                viewModel.name.value  ?: "", viewModel.description.value ?: ""
                , EditTextFragment.DESCRIPTION_VIEW).show(childFragmentManager, "EditText")
        }

        binding.deleteButton.setOnClickListener {
            val dialogBuilder = AlertDialog.Builder(binding.root.context)
            dialogBuilder.setTitle("Are you sure?")
            val taskName = if(viewModel.name.value == null || viewModel.name.value!!.length < 20) viewModel.name.value
            else viewModel.name.value!!.substring(0, 20)
            dialogBuilder.setMessage("\"$taskName\" will be permanently deleted.")
            dialogBuilder.setPositiveButton("Delete") { dialog, whichButton ->
                viewModel.deleteTask()
                Toast.makeText(context, "Task deleted!", Toast.LENGTH_SHORT).show()
                dismiss()
            }
            dialogBuilder.setNegativeButton("Cancel") { dialog, whichButton ->
                dialog.cancel()
            }
            val b = dialogBuilder.create()
            b.show()
        }
    }

    override fun onCreateContextMenu(
        menu: ContextMenu,
        v: View,
        menuInfo: ContextMenu.ContextMenuInfo?
    ) {
        super.onCreateContextMenu(menu, v, menuInfo)
        menu.setHeaderTitle("Check task as...")
        menu.add(
            Menu.NONE, R.id.context_menu_completed,
            Menu.NONE, R.string.menu_completed
        ).setOnMenuItemClickListener {
            viewModel.setStatus(1)
            true
        }
        menu.add(
            Menu.NONE, R.id.context_menu_wont_do,
            Menu.NONE, R.string.menu_wont_do
        ).setOnMenuItemClickListener {
            viewModel.setStatus(2)
            true
        }
//        onContextItemSelected not working
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
        //         * @param id Parameter 1.
         * @return A new instance of fragment DetailFragment.
         */
        fun newInstance(task: Task) =
            ReadFragment().apply {
                arguments = Bundle().apply {
                    putParcelable(ARG_TASK, task)
                }
            }
    }
}

