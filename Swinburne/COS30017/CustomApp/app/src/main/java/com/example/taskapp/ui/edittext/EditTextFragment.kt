package com.example.taskapp.ui.edittext

import android.app.Dialog
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import android.view.inputmethod.InputMethodManager
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.content.res.AppCompatResources
import androidx.core.content.ContextCompat
import androidx.core.os.bundleOf
import androidx.fragment.app.setFragmentResult
import androidx.lifecycle.MutableLiveData
import com.example.taskapp.R
import com.example.taskapp.databinding.FragmentEditTextBinding
import com.example.taskapp.ui.utils.formatDate
import com.google.android.material.bottomsheet.BottomSheetBehavior
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import kotlin.properties.Delegates

/**
 * A simple [Fragment] subclass.
 * Use the [EditTextFragment.newInstance] factory method to
 * create an instance of this fragment.
 */
class EditTextFragment : BottomSheetDialogFragment() {

    private lateinit var name: String
    private var description: String? = null
    private lateinit var oldName: String
    private var oldDescription: String? = null
    private var changed: MutableLiveData<Boolean> = MutableLiveData(false)

    private var focus by Delegates.notNull<Int>()

    private var _binding: FragmentEditTextBinding? = null

    // This property is only valid between onCreateView and onDestroyView.
    private val binding get() = _binding!!

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        arguments?.let {
            name = it.getString(ARG_NAME).toString()
            description = it.getString(ARG_DESCRIPTION)
            oldName = it.getString(ARG_OLD_NAME).toString()
            oldDescription = it.getString(ARG_OLD_DESCRIPTION)
            changed.value = it.getBoolean(ARG_CHANGED)
            focus = it.getInt(ARG_FOCUSING_VIEW)
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        _binding = FragmentEditTextBinding.inflate(inflater, container, false)
        return binding.root
    }

    private fun checkChanged() {
        name = name.trim { it <= ' ' }
        description = description?.trim { it <= ' ' }
        changed.value = (name != oldName || description != oldDescription) && !name.isNullOrEmpty()
    }

    override fun onCreateDialog(savedInstanceState: Bundle?): Dialog {

        // Set fragment to half screen
        val dialog = super.onCreateDialog(savedInstanceState)
        dialog.setOnShowListener {
            val bottomSheetDialog = it as BottomSheetDialog
            val parentLayout = bottomSheetDialog.findViewById<View>(
                com.google.android.material.R.id.design_bottom_sheet
            )
            parentLayout?.let { bottomSheet ->
                val behaviour = BottomSheetBehavior.from(bottomSheet)
                val layoutParams = bottomSheet.layoutParams
                layoutParams.height = WindowManager.LayoutParams.MATCH_PARENT
                bottomSheet.layoutParams = layoutParams
                behaviour.state = BottomSheetBehavior.STATE_HALF_EXPANDED
            }
        }
        return dialog
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.nameView.setText(name)
        binding.descriptionView.setText(description)
        changed.observe(viewLifecycleOwner) {
            if (changed.value == true) {
                binding.saveIcon.visibility = View.VISIBLE
                binding.saveIcon.setImageDrawable(AppCompatResources.getDrawable(
                    binding.root.context, R.drawable.ic_save
                ))
            } else {
                binding.saveIcon.visibility = View.GONE
            }
        }

        binding.nameView.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(str: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(str: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(str: Editable) {
                name = str.toString().trim { it <= ' ' }
                checkChanged()
                if (name.isNullOrEmpty()) {
                    binding.nameView.error = "Task name cannot be empty."
                }
            }
        })

        binding.descriptionView.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(str: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(str: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(str: Editable) {
                description = str.toString().trim { it <= ' ' }
                checkChanged()
            }
        })

        binding.saveIcon.setOnClickListener {
            onClickSaved()
        }

        binding.cancelIcon.setOnClickListener {
            onClickCancel()
        }

        // show keyboard immediately to input
        val imm: InputMethodManager = ContextCompat.getSystemService(
            view.context,
            InputMethodManager::class.java
        ) as InputMethodManager

        if (focus == NAME_VIEW) {
            binding.nameView.requestFocus()
            imm.showSoftInput(binding.nameView, InputMethodManager.SHOW_IMPLICIT)
        }
        else {
            binding.descriptionView.requestFocus()
            imm.showSoftInput(binding.descriptionView, InputMethodManager.SHOW_IMPLICIT)
        }
    }

    private fun onClickCancel() {
        if(name != oldName || description != oldDescription) {
            val dialogBuilder = context?.let { it1 -> AlertDialog.Builder(it1) }
            dialogBuilder?.setTitle("Discard changes?")
            dialogBuilder?.setMessage("The changes you have made will not be saved.")
            dialogBuilder?.setPositiveButton("Discard") { _, _ ->
                changed.value = false
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

    private fun onClickSaved() {
        if(changed.value == true) {
            oldName = name
            oldDescription = description
            changed.value = false
            setFragmentResult(REQUEST_KEY, bundleOf(ARG_NAME to name, ARG_DESCRIPTION to description))
            Toast.makeText(context, "Edit saved!", Toast.LENGTH_SHORT).show()
        }
    }

    override fun onSaveInstanceState(outState: Bundle) {
        outState.putString(ARG_NAME, name)
        outState.putString(ARG_DESCRIPTION, description)
        outState.putString(ARG_OLD_NAME, oldName)
        outState.putString(ARG_OLD_DESCRIPTION, oldDescription)
        changed.value?.let { outState.putBoolean(ARG_CHANGED, it) }
        super.onSaveInstanceState(outState)
    }

    companion object {
        /**
         * Use this factory method to create a new instance of
         * this fragment using the provided parameters.
         *
         * @param name Name
         * @param description Description
         * @return A new instance of fragment EditFragment.
         */
        @JvmStatic
        fun newInstance(name: String, description: String, focus: Int) =
            EditTextFragment().apply {
                oldName = name.trim { it <= ' ' }
                oldDescription = description.trim { it <= ' ' }
                arguments = Bundle().apply {
                    putString(ARG_NAME, name)
                    putString(ARG_DESCRIPTION, description)
                    putString(ARG_OLD_NAME, oldName)
                    putString(ARG_OLD_DESCRIPTION, oldDescription)
                    putInt(ARG_FOCUSING_VIEW, focus)
                }
            }

        const val NAME_VIEW = 1
        const val DESCRIPTION_VIEW = 2
        const val REQUEST_KEY = "requestKey"
        const val ARG_NAME = "name"
        const val ARG_DESCRIPTION = "description"
        const val ARG_OLD_NAME = "name"
        const val ARG_OLD_DESCRIPTION = "description"
        const val ARG_CHANGED = "changed"
        const val ARG_FOCUSING_VIEW = "focusing_view"
    }
}