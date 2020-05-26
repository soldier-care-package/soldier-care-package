import React from 'react';
import {UseJwt, UseJwtProfileUsername} from "../../shared/utils/jwt-helpers";
import {Formik} from "formik/dist/index";
import * as Yup from "yup";
import {RequestContent} from "./RequestContent"
import {httpConfig} from "../../shared/utils/http-config.js";



export const RequestForm = () => {

	const jwt = UseJwt();
	const profileUsername = UseJwtProfileUsername();

	const validator = Yup.object().shape({
		requestContent: Yup.string()
			.required("request Content is required"),
		itemUrl: Yup.string()
			.url("item must be a valid url")
			.required('item is required'),
		secondItemUrl: Yup.string()
			.url("item must be a valid url"),
		thirdItemUrl: Yup.string()
			.url("item must be a valid url"),
		fourthItemUrl: Yup.string()
			.url("item must be a valid url"),
		fifthItemUrl: Yup.string()
			.url("item must be a valid url"),
	});


	//the initial values object defines what the request payload is.
	const item = {
		requestContent: "",
		itemUrl: "",
		secondItemUrl: "",
		thirdItemUrl: "",
		fourthItemUrl: "",
		fifthItemUrl: ""
	};

	const submitItem = (values, {resetForm, setStatus}) => {

		const headers = {'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")}

const requestValue= {"requestContent": values.requestContent}
		httpConfig.post("/apis/request/", requestValue, {
			headers:headers
		})

			.then(reply => {
				// let {message, type} = reply;
				// setStatus({message, type});
				if(reply.status === 200) {

					let items = values
					delete items.requestContent

					for (const itemIndex in items) {
						if(items[itemIndex]) {


						const itemValue = {"itemRequestId": reply.data.requestId, "itemUrl": items[itemIndex]}
						httpConfig.post("/apis/item/", itemValue, {
							headers: headers
						})

							.then(reply => {
								let {message, type} = reply;
								setStatus({message, type});
								if(reply.status === 200) {
									resetForm();
									alert(message);
								}
							});
					}
					}
				}
			});


	};

	return (
		<>
			{ jwt !== null && (
				<h1 className="display-4">Create a New Request<br/> {profileUsername}</h1>
			)}
			<Formik
				initialValues={item}
				onSubmit={submitItem}
				validationSchema={validator}
			>
				{RequestContent}
			</Formik>
		</>
	)
};