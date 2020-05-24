import React, {useState} from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";

export const SignUpForm = ({handleClose}) => {
	const signUp = {
		profileName:"",
		profileUsername: "",
		profileType:"",
		profileEmail: "",
		profilePassword: "",
		profilePasswordConfirm: "",
	};

	const [status, setStatus] = useState(null);
	const validator = Yup.object().shape({
		profileName: Yup.string()
			.required("Profile name is required"),
		profileUsername: Yup.string()
			.required("Profile username is required"),
		profileType: Yup.string()
			.required("Profile type is required"),
		profileEmail: Yup.string()
			.email("Email must be a valid email")
			.required('Email is required'),
		profilePassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		profilePasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),

	});

	const submitSignUp = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;

					if(reply.status === 200) {
						resetForm();
						alert(message);
						handleClose();
					} setStatus({message, type});
				}
			);
	};


	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};