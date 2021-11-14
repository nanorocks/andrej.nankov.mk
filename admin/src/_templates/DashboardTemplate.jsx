import React from "react";
import ContainerPicasso from "../_organisms/ContainerPicasso";
import {
  Base,
  Quotes,
  Highlights,
  SocMedia,
  ProgrammingLanguages,
  Work,
  Summary,
  Goals,
  Intro
} from "../_organisms/_index";

export default function DashboardTemplate() {
  return (
    <ContainerPicasso className="pt-5">
      <Base></Base>
      <Goals></Goals>
      <Quotes></Quotes>
      <Intro></Intro>
      <Highlights></Highlights>
      <SocMedia></SocMedia>
      <ProgrammingLanguages></ProgrammingLanguages>
      <Work></Work>
      <Summary></Summary>
    </ContainerPicasso>
  );
}
